<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\Question\Question;
use App\Models\Question\QuestionGroup;
use App\Models\Question\QuestionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartController extends Controller
{
    private function splitNumberFromName($part_name): string
    {
        // Tách số thứ tự phần từ tên phần
        preg_match('/\d+(?:\s*[-–]\s*\d+)?/', $part_name, $matches);

        return $matches[0] ?? '';
    }

    public function add($exam_id) :View
    {
        $exam = Exam::find($exam_id);

        $exam->load('folder'); // Eager load the folder relationship
        $exam->load('parts'); // Eager load the folder relationship
        $data['exam'] = $exam;
        $data['questionTypes'] = QuestionType::with('configKeys')->get();
        $data['exam_id'] = $exam_id;
        $data['part_number'] =  $exam->parts->count() + 1; // Tăng số thứ tự phần lên 1 so với số phần hiện tại

        return view('admin.content.part.add', $data);
    }

    private function handleAttachedFiles($input): false|string|null
    {
        if (!isset($input) || trim($input )== '') return null;
        $input = array_map('trim', explode(',', $input));
        return json_encode($input);
    }

    private function createOrUpdatePart($exam_id, $part_id, $input, $is_create = true): Part|null
    {
        $part = Part::find($part_id);
        $data = [
            'exam_id' => $exam_id,
            'number' => $this->splitNumberFromName($input['part_name']),
            'name' => $input['part_name'],
            'description' => $input['part_description'] ?? null,
            'time' => $input['part_time'] ?? null,
            'part_type' => $input['part_type'] ?? null,
            'content' => $input['part_content'] ?? null,
            'attached_file' => $this->handleAttachedFiles($input['part_attachment'] ?? null),
        ];

        if (!$part)
            if ($is_create) return Part::create($data);
            else return null;
        // nếu không tìm thấy phần thì tạo mới
        $part->update($data); // nếu tìm thấy phần thì cập nhật thông tin
        return $part; // trả về phần đã được tạo hoặc cập nhật
    }

    private function createOrUpdateQuestionGroup($part_id, $questionGroup_id, $questionGroupInput , $is_create = true): QuestionGroup|null
    {
        $questionGroup = QuestionGroup::find($questionGroup_id);
        $data = [
            'part_id' => $part_id,
            'name' => $questionGroupInput['name'],
            'content' => $questionGroupInput['content'] ?? null,
            'description' => $questionGroupInput['description'] ?? null,
            'attached_file' => $this->handleAttachedFiles($questionGroupInput['attachment'] ?? null),
            'answer_inside_content' => isset($questionGroupInput['answer_inside_content']),
            'answer_content' => $questionGroupInput['answer_content'] ?? null
        ];
        if (!$questionGroup)
            if ($is_create) return QuestionGroup::create($data); // nếu không tìm thấy nhóm câu hỏi thì tạo mới
            else return null;
        $questionGroup->update($data); // nếu tìm thấy nhóm câu hỏi thì cập nhật thông tin
        return $questionGroup; // trả về nhóm câu hỏi đã được tạo hoặc cập nhật
    }

    private function createOrUpdateQuestion($questionGroup_id, $question_id, $questionInput, $is_create = true): Question|null
    {
        $question = Question::find($question_id);
        $data = [
            'question_group_id' => $questionGroup_id,
            'number' => $this->splitNumberFromName($questionInput['label']),
            'name' => $questionInput['label'],
            'input_type' => $questionInput['input_type'],
            'question_type_id' => $questionInput['question_type_id'] ?? null,
            'score' => $questionInput['score'] ?? 0,
            'content' => $questionInput['content'] ?? null,
            'attached_file' => json_encode([])
        ];
        if (!$question)
            if ($is_create) $question =  Question::create($data); // nếu không tìm thấy câu hỏi thì tạo mới
            else return null;
        else $question->update($data); // nếu tìm thấy câu hỏi thì cập nhật thông tin

        // update or create answers for the question
        // get all key in $questionInput['answer']
        $question->load('answers'); // Eager load answers relationship
        $existingAnswerIds = $question->answers->pluck('id')->toArray();
        $newAnswerIds = array_keys($questionInput['answer'] ?? []);
        // Phân loại các ID
        $answerIdsToUpdate = array_intersect($existingAnswerIds, $newAnswerIds); // tồn tại trong cả 2 mảng
        $answerIdsToDelete = array_diff($existingAnswerIds, $newAnswerIds); // tồn tại trong mảng cũ nhưng không có trong mảng mới
        // Xoá các câu trả lời không còn trong input mới (gộp lại 1 query duy nhất)
        if (!empty($answerIdsToDelete)) Question::whereIn('id', $answerIdsToDelete)->delete();

        $answers = $questionInput['answer'] ?? [];

        foreach ($answers as $answerKey => $answerInput) {
            if (in_array($answerKey, $answerIdsToUpdate)) {
                // update existing answer
                $answer = $question->answers()->find($answerKey);
                if ($answer) {
                    switch($question['input_type']) {
                        case 'radio':
                        case 'checkbox':
                        case 'select':
                            $answer->update([
                                'label' => $answerInput['label'] ?? $answer['label'],
                                'value' => $answerInput['text'] ?? $answer['text'],
                                'is_correct' => isset($answerInput['is_correct']),
                                'note' =>  $answerInput['note'] ?? $answer['note']
                            ]);
                            break;
                        default:
                            $values_array = array_map('trim', explode(",", $answer['text'] ?? '')); // Trim whitespace from each value
                            $answer->update([
                                'label' => $answerInput['label'] ?? $answer['label'],
                                'value' => json_encode($values_array),
                                'is_correct' =>  true,
                                'note' =>  $answerInput['note'] ?? $answer['note']
                            ]);
                            break;
                    }
                }
            } else{
                // create new answer
                switch ($question['input_type']) {
                    case 'radio':
                    case 'checkbox':
                    case 'select':
                        $question->answers()->create([
                            'label' => $answerInput['label'] ?? null,
                            'value' => $answerInput['text'] ?? null,
                            'is_correct' => isset($answerInput['is_correct']),
                            'note' =>  $answerInput['note'] ?? null
                        ]);
                        break;
                    default:
                        $values_array = array_map('trim', explode(",", $answerInput['text'] ?? '')); // Trim whitespace from each value
                        $question->answers()->create([
                            'value' => json_encode($values_array),
                            'is_correct' => true,
                            'note' =>  $answerInput['note'] ?? null
                        ]);
                        break;
                }
            }
        }

        return $question;
    }

    public function store($exam_id, Request $request): RedirectResponse
    {
        $input = $request->all();

        // Get part information from the request
        $part = $this -> createOrUpdatePart($exam_id, null, $input);

        $questionGroups = $input['question_groups'] ?? [];
        foreach ($questionGroups as $questionGroupInput) {
            // Question Group information
            $questionGroup = $this -> createOrUpdateQuestionGroup($part->id, null, $questionGroupInput);
            $questions = $questionGroupInput['questions'] ?? [];

            //Question information
            foreach ($questions as $questionInput) {
                $question = $this->createOrUpdateQuestion($questionGroup->id, null, $questionInput);
            }
        }

       return redirect()->route('admin.exam.detail', ['id' => $exam_id])
            ->with('success', 'Đã thêm phần "' . $part->name . '" thành công.');

    }

    public function edit($exam_id, $id): View|RedirectResponse
    {
        $part = Part::find($id);
        if (!$part) {
            return redirect()->route('admin.exam.detail', ['id' => $exam_id])
                ->with('error', 'Phần không tồn tại hoặc đã bị xóa trước đó.');
        }

        $part->load('questionGroups.questions.answers'); // Eager load relationships
        $data['part'] = $part;
        $data['exam'] = Exam::find($exam_id);
        $data['questionTypes'] = QuestionType::with('configKeys')->get();
        // max question_id
        $data['max_question_group_id'] = $part->questionGroups->max('id') + 1;
        $data['max_question_id'] = $part->questionGroups->flatMap(function ($group) {
            return $group->questions;
        })->max('id') + 1;


        return view('admin.content.part.edit', $data);
    }

    public function update($exam_id, $id, Request $request): RedirectResponse
    {
        $input = $request->all();
       /* echo "<pre>";
        print_r($input);
        echo "</pre>";
        exit;*/

        // update part information
        $part = $this->createOrUpdatePart($exam_id, $id, $input, false);
        if (!$part) return redirect()->route('admin.exam.detail', ['id' => $exam_id])
                ->with('error', 'Phần không tồn tại hoặc đã bị xóa trước đó.');

        // update question groups
        $questionGroups = $input['question_groups'] ?? [];

        // get all key in $questionGroups
        $existingGroupIds = $part->questionGroups->pluck('id')->toArray();
        $newGroupIds = array_keys($questionGroups);
        // Phân loại các ID
        $idsToUpdate = array_intersect($existingGroupIds, $newGroupIds);
        $idsToDelete = array_diff($existingGroupIds, $newGroupIds);
        $idsToCreate = array_diff($newGroupIds, $existingGroupIds);


        // Xoá các nhóm không còn trong input mới (gộp lại 1 query duy nhất)
        if (!empty($idsToDelete)) QuestionGroup::whereIn('id', $idsToDelete)->delete();

        foreach ($questionGroups as $key => $questionGroupInput) {
            if (in_array($key, $idsToCreate))
                $questionGroup = $this->createOrUpdateQuestionGroup($part->id, $key, $questionGroupInput, true);
            else
                $questionGroup = $this->createOrUpdateQuestionGroup($part->id, $key, $questionGroupInput, false);
            if (!$questionGroup) return redirect()->route('admin.part.edit', ['exam_id' => $exam_id, 'id' => $id])
                ->with('error', 'Không thể cập nhật nhóm câu hỏi.'.$key.' Vui lòng thử lại sau.');

            $questions = $questionGroupInput['questions'] ?? [];
            // get all key in $questions
            $existingQuestionIds = $questionGroup->questions->pluck('id')->toArray();
            $newQuestionIds = array_keys($questions);
            // Phân loại các ID
            $questionIdsToUpdate = array_intersect($existingQuestionIds, $newQuestionIds);
            $questionIdsToDelete = array_diff($existingQuestionIds, $newQuestionIds);
            $questionIdsToCreate = array_diff($newQuestionIds, $existingQuestionIds);
            // Xoá các câu hỏi không còn trong input mới (gộp lại 1 query duy nhất)
            if (!empty($questionIdsToDelete)) Question::whereIn('id', $questionIdsToDelete)->delete();
            foreach ($questions as $questionKey => $questionInput) {
                if (in_array($questionKey, $questionIdsToUpdate)) {
                    // update existing question
                    $question = $this->createOrUpdateQuestion($questionGroup->id, $questionKey, $questionInput, false);
                } elseif (in_array($questionKey, $questionIdsToCreate)) {
                    // create new question
                    $question = $this->createOrUpdateQuestion($questionGroup->id, null, $questionInput, true);
                }
            }
        }
        return redirect()->route('admin.exam.detail', ['id' => $exam_id])
            ->with('success', 'Đã cập nhật phần "' . $part->name . '" thành công.');
    }

    public function destroy($exam_id, Request $request): RedirectResponse
    {
        $part = Part::find($request->input('del-object-id'));
        if ($part) {
            $part->delete();
            return redirect()->route('admin.exam.detail', ['id' => $exam_id])
                ->with('success', 'Đã xóa phần "' . $part->name . '" thành công.');
        }
        return redirect()->route('admin.exam.detail', ['id' => $exam_id])
            ->with('error', 'Phần không tồn tại hoặc đã bị xóa trước đó.');
    }

}
