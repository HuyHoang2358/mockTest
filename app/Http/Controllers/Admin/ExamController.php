<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question\QuestionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExamController extends Controller
{
    private function generateExamCode(): string
    {
        $existingCodes = collect(Exam::pluck('code')->all());
        do {
            $code = Str::lower(Str::random(8));
        } while ($existingCodes->has($code));

        return $code;
    }

    public function index(){


    }

    public function detail($id): RedirectResponse|View
    {
        $exam = Exam::find($id);
        if (!$exam) return redirect()->route('admin.exam.index')->with('error', 'Bài tập, đề thi không tồn tại');

        $exam->load('folder'); // Eager load the folder relationship
        $exam->load('parts'); // Eager load the folder relationship
        $data['exam'] = $exam;
        $data['questionTypes'] = QuestionType::with('configKeys')->get();

        return view('admin.content.exam.detail', $data);

    }
    public function store(Request $request): RedirectResponse
    {
        // Logic to store exam data

        $input = $request->all();
        // Validate and process the input data


        $exam = Exam::create([
            'folder_id' => $input['exam_folder_id'],
            'name' => $input['exam_name'],
            'code' => $this->generateExamCode(),
            'exam_total_time' => $input['exam_total_time'] ?? null,
            'start_time' => $input['exam_start_time'] ?? null,
            'end_time' => $input['exam_end_time'] ?? null,
            'password' => $input['exam_password'] ?? null,
            'price' => $input['exam_price'] ?? 0,
            'is_payment' => ($input['exam_price'] ?? 0) > 0,
            'number_of_todo' => $input['exam_number_of_todo'] ?? 1,
        ]);

        return redirect()->route('admin.exam.detail', $exam->id)->with('success', 'Thêm mới bài tập, đề thi thành công');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return redirect()->back()->with('error', 'Bài tập, đề thi không tồn tại');
        }

        $input = $request->all();
        // Validate and process the input data

        $exam->update([
            'folder_id' => $input['exam_folder_id'],
            'name' => $input['exam_name'],
            'exam_total_time' => $input['exam_total_time'] ?? null,
            'start_time' => $input['exam_start_time'] ?? null,
            'end_time' => $input['exam_end_time'] ?? null,
            'password' => $input['exam_password'] ?? null,
            'price' => $input['exam_price'] ?? 0,
            'is_payment' => ($input['exam_price'] ?? 0) > 0,
            'number_of_todo' => $input['exam_number_of_todo'] ?? 1,
        ]);

        return redirect()->back()->with('success', 'Cập nhật bài tập, đề thi thành công');
    }


    public function destroy(Request $request): RedirectResponse
    {
        $exam = Exam::find($request->input('del-object-id'));
        if ($exam) {
            $exam->delete();
            return redirect()->back()
                ->with('success', 'Đã xóa đề thi\bài tập "' . $exam->name . '" thành công.');
        }
        return redirect()->back()
            ->with('error', 'Đề thi không tồn tại, hoặc đã bị xóa trước đó.');
    }

}
