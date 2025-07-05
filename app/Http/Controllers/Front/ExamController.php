<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question\Question;
use App\Models\UserAnswerHistory;
use App\Models\UserExamHistory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExamController extends Controller
{
    private function checkAccess(Exam $exam): bool
    {
        if (!$exam->status) return false;
        return true;
    }

    public function index($code): View|RedirectResponse
    {
        $exam = Exam::where('code', $code)->first();
        $data['exam'] = $exam;
        $data['myAnswer'] = UserExamHistory::where('exam_id', $exam->id)->where('user_id', Auth::id())->first();
        return view('front.content.exam.index', $data);
    }

    public function exercise($code) :View|RedirectResponse
    {

        if (!Auth::user()) return redirect()->back()->with('error', 'Bạn cần đăng nhập để làm bài tập');

        $exam = Exam::where('code', $code)->first();
        if (!$exam) return redirect()->back()->with('error', '404 Not Found');
        $ok = $this->checkAccess($exam);
        if (!$ok) {
            return view('front.content.exam.error', ['exam' => $exam]);
        }

        // Kiểm tra xem người dùng đã vào thi chưa?
        $user_exam_history = UserExamHistory::where('user_id', auth()->user()->id)
            ->where('exam_id', $exam->id)->first();
        $data['exam'] = $exam;
        $exam->load('parts');

        if (!$user_exam_history) {
            // Chưa từng thi
            // create new history
            $startTime = Carbon::now();
            $endTime = $startTime->copy()->addMinutes($exam->time);
            UserExamHistory::create([
                'user_id' => auth()->user()?->id ?? 0,
                'exam_id' => $exam->id,
                'user_name' => auth()->user()?->name ?? 'Khách',
                'start_at' => $startTime,
                'end_at' => $endTime,
                'status' => 'DOING',
                'score' => 0,
            ]);
            $data['leftTime'] = $exam->time * 60; // Convert time to seconds
        }else{
            // Đã từng thi
            if ($user_exam_history->status == 'DONE'){
                // Đã thi xong
                return redirect()->back()->withErrors(['message' => 'Bạn đã thi xong rồi']);
            }

            $now = Carbon::now();
            $data['leftTime'] = round($now->diffInSeconds($user_exam_history->end_at, false),0);
        }
        return view('front.content.exam.detail', $data);
    }

    public function todo($code) :View|RedirectResponse
    {
        $exam = Exam::where('code', $code)->first();
        if (!$exam) return redirect()->back()->with('error', '404 Not Found');

        $data['exam'] = $exam;
        $data['leftTime'] = $exam->time * 60; // Convert time to seconds
        return view('front.content.exam.detail', $data);
    }

    // Ghi câu trả lời của người dùng vào lịch sử
    public function answerHistory($code, $questionId, Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'Bạn cần đăng nhập để làm bài thi'], 401);

        $exam = Exam::where('code', $code)->first();
        if (!$exam) response()->json(['message' => 'Không tìm thấy bài thi'], 404);

        $question = Question::find($questionId);
        if (!$question) return response()->json(['message' => 'Không tìm thấy câu hỏi'], 404);

        $user_exam_history = UserExamHistory::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();
        if (!$user_exam_history) return response()->json(['message' => 'Không tìm thấy lịch sử bài thi'], 404);

        if ($user_exam_history->status != 'DOING') return response()->json(['message' => 'Bài thi đã kết thúc'], 404);

        $input = $request->all();
        if (empty($input['answer'])) {
            $user_answer = UserAnswerHistory::where('user_id', $user->id)
                ->where('exam_id', $exam->id)
                ->where('question_id', $questionId)
                ->first();
            if ($user_answer) {
                // Xóa câu trả lời nếu không có input
                $user_answer->delete();
                return response()->json(['message' => 'Xóa câu trả lời thành công!']);
            }
        }
        $user_answer = UserAnswerHistory::updateOrCreate([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'question_id' => $questionId,
        ],[
            'user_id' => $user->id,
            'user_name' => $user->name ?? 'Khách',
            'exam_id' => $exam->id,
            'question_id' => $questionId,
            'answer' => $input['answer'],
            'is_correct' => -1, // -1: chưa chấm, 0: sai, 1: đúng
            'point' => 0,
        ]);

        return response()->json([
            'message' => 'Lưu câu trả lời thành công!',
            'user_answer' => $user_answer->only(['id', 'user_id', 'exam_id', 'question_id', 'answer']),
        ]);
    }

    // Kêt thúc bài thi
    public function finishExam($code): RedirectResponse
    {
        $user = Auth::user();
        if (!$user) return redirect()->back()->with('error', 'Bạn cần đăng nhập để làm bài thi');

        $exam = Exam::where('code', $code)->first();
        if (!$exam) return redirect()->back()->with('error', 'Không tìm thấy bài thi');

        // update user
        $user_exam_history = UserExamHistory::where('user_id', auth()->user()?->id)
            ->where('exam_id', $exam->id)
            ->first();

        if (!$user_exam_history || $user_exam_history->status == 'DONE')  return redirect()->back()->with(['error' => 'Submit không hợp lệ']);
        // Cập nhật trạng thái bài thi
        $user_exam_history->status = 'DONE';
        $user_exam_history->end_at = Carbon::now();
        $user_exam_history->save();

        $this->checkAnswerAuto($user_exam_history->id);
        return redirect()->route('user.exam.index', $exam->code)->with('success', 'Bạn đã kết thúc bài thi thành công!');
    }

    public function checkAnswerAuto($userExamHistoryId): void
    {
        $user_exam_history = UserExamHistory::find($userExamHistoryId);
        if (!$user_exam_history) return;

        $user_answer_histories = UserAnswerHistory::where('user_id', $user_exam_history->user_id)
            ->where('exam_id', $user_exam_history->exam_id)
            ->get();
        echo "Đang chấm bài thi: " . count($user_answer_histories) . "\n";
        $checked = 0;
        $point = 0;
        foreach ($user_answer_histories as $user_answer) {
            $question = Question::find($user_answer->question_id)->load('answers');
            $input_type = $question->input_type;
            switch ($input_type) {
                case 'radio':
                case 'select':
                    // Kiểm tra đáp án đúng
                    $correct_answer = $question->answers->where('is_correct', 1)->first();
                    if ($correct_answer){
                        if ($user_answer->answer == $correct_answer->value) {
                            $user_answer->is_correct = 1;
                            $user_answer->point = $question->score;
                            $point += $question->score;
                        } else {
                            $user_answer->is_correct = 0;
                            $user_answer->point = 0;
                        }
                        $checked++;
                    }

                    break;
                case 'checkbox':
                    // Kiểm tra đáp án đúng
                    $correct_answers = $question->answers->where('is_correct', 1)->pluck('value')->toArray();
                    $correct_answers = join('||', $correct_answers);
                    if($correct_answers){
                        if ($correct_answers == $user_answer->answer) {
                            $user_answer->is_correct = 1;
                            $user_answer->point = $question->score;
                            $point += $question->score;
                        } else {
                            $user_answer->is_correct = 0;
                            $user_answer->point = 0;
                        }
                        $checked++;
                    }
                    break;
                case 'text':
                    // Kiểm tra đáp án đúng
                    $correct_answer = $question->answers->where('is_correct', 1)->first();
                    if ($correct_answer){
                       $arr = json_decode($correct_answer, true) ?: [];
                       if (count($arr) >0){
                            $ok = false;
                            foreach ($arr as $value){
                                if ($user_answer->answer == $value) {
                                    $user_answer->is_correct = 1;
                                    $user_answer->point = $question->score;
                                    $point += $question->score;
                                    $ok = true;
                                    break; // Chỉ cần đúng một phần là đủ
                                }
                            }
                            if (!$ok) {
                                $user_answer->is_correct = 0;
                                $user_answer->point = 0;
                            }
                           $checked++;
                       }
                    }
                    break;
                case 'textarea':
                    break;

                default:
                    // Không hỗ trợ kiểm tra tự động
                    break;
            }

            // Lưu kết quả câu trả lời
            $user_answer ->save();
        }

        $user_exam_history ->score = $point;
        $exam = $user_exam_history->exam;
        if ($checked == $exam->total_question) $user_exam_history->status = 'CHECKED';
        else $user_exam_history->status = 'CHECKING';
        $user_exam_history->save();
    }


}
