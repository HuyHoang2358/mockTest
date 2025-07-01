<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\Question\QuestionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartController extends Controller
{
    private function splitNumberFromName($part_name): int
    {
        // Tách số thứ tự phần từ tên phần
        $part_number = preg_replace('/[^0-9]/', '', $part_name);
        return (int)$part_number;
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

    public function store($exam_id, Request $request){
        $input = $request->all();
       /* echo "<pre>";
        print_r($input);
        echo "</pre>";
        exit;*/


        // Get part information from the request
        $part = Part::create([
            'exam_id' => $exam_id,
            'number' => $this->splitNumberFromName($input['part_name']),
            'name' => $input['part_name'],
            'content' => $input['part_content'] ?? null,
            'attached_file' => $this->handleAttachedFiles($input['part_attachment'] ?? null),
            'part_type' =>'----'
        ]);

        $questionGroups = $input['question_groups'] ?? [];
        foreach ($questionGroups as $questionGroupInput) {
            $questionGroup = $part->questionGroups()->create([
                'name' => $questionGroupInput['name'],
                'content' => $questionGroupInput['content'] ?? null,
                'attached_file' => $this->handleAttachedFiles($questionGroupInput['attachment'] ?? null),
                'answer_inside_content' => isset($questionGroupInput['answer_inside_content'])
            ]);
            $questions = $questionGroupInput['questions'] ?? [];
            foreach ($questions as $questionInput) {
                $question = $questionGroup->questions()->create([
                    'number' => $this->splitNumberFromName($questionInput['label']),
                    'name' => $questionInput['label'],
                    'input_type' => $questionInput['input_type'],
                    'question_type_id' => $questionInput['question_type_id'] ?? null,
                    'score' => $questionInput['score'] ?? 0,
                    'content' => $questionInput['content'] ?? null,
                    'attached_file' => json_encode([])
                ]);

                $answers = $questionInput['answer'] ?? [];
                switch ($question['input_type']) {
                    case 'radio':
                    case 'checkbox':
                        foreach ($answers as $answer) {
                            $question->answers()->create([
                                'label' => $answer['label'] ?? null,
                                'value' => $answer['text'] ?? null,
                                'is_correct' => isset($answer['is_correct']),
                                'note' =>  $answer['note'] ?? null
                            ]);
                        }
                        break;
                    default:
                        foreach ($answers as $answer) {
                            $values_array = array_map('trim', explode(",", $answer['text'] ?? '')); // Trim whitespace from each value
                            $question->answers()->create([
                                'value' => json_encode($values_array),
                                'is_correct' => true,
                                'note' =>  $answer['note'] ?? null
                            ]);
                        }
                        break;
                }

            }

        }
       return redirect()->route('admin.exam.detail', ['id' => $exam_id])
            ->with('success', 'Đã thêm phần "' . $part->name . '" thành công.');

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
