<?php

namespace App\Http\Controllers\Admin\Question;

use App\Http\Controllers\Controller;
use App\Models\Question\QuestionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionTypeController extends Controller
{
    public function index() :View
    {
        $data['question_types'] = QuestionType::orderBy('name', 'asc')->with('configKeys')->get();
        $data['page'] = 'manage-question-type';
        return view('admin.content.question.question_type.index', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();

        $questionType = QuestionType::create([
            'name' => $input['question_type_name'],
            'description' => $input['question_type_description'] ?? '',
        ]);

        if (empty($input['question_type_config_key'])) {
            return redirect()->back()->withInput()->with('error', 'Cấu hình của câu hỏi không được để trống');
        }

        // Attach config keys if provided
        $num_key = count($input['question_type_config_key']);
        for ($i = 0; $i < $num_key; $i++) {
            if (!empty($input['question_type_config_key'][$i])) {
                $value = $input['question_type_config_value'][$i] ?? '';
                $value = trim($value);
                $valueArr = $value === '' ? [] : explode(',', $value);

                $questionType->configKeys()->create([
                    'key' => $input['question_type_config_key'][$i],
                    'description' => $input['question_type_config_description'][$i] ?? '',
                    'is_required' => isset($input['question_type_config_is_require'][$i]) ? 1 : 0,
                    'value' => json_encode($valueArr)
                ]);
            }
        }
        return redirect()->route('admin.question-type.index')->with('success', 'Thêm loại câu hỏi thành công');
    }

    public function edit($id): View
    {
        $data['item'] = QuestionType::with('configKeys')->findOrFail($id);
        $data['page'] = 'manage-question-type';
        return view('admin.content.question.question_type.edit', $data);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $input = $request->all();
        $questionType = QuestionType::find($id);
        if (!$questionType) {
            return redirect()->route('admin.question-type.index')->with('error', 'ID Loại câu hỏi không tồn tại');
        }
        if (empty($input['question_type_config_key'])) {
            return redirect()->back()->withInput()->with('error', 'Cấu hình của câu hỏi không được để trống');
        }

        $questionType->update([
            'name' => $input['question_type_name'],
            'description' => $input['question_type_description'] ?? '',
        ]);

        // Update config keys
        $questionType->configKeys()->delete(); // Clear existing config keys

        $num_key = count($input['question_type_config_key']);
        for ($i = 0; $i < $num_key; $i++) {
            if (!empty($input['question_type_config_key'][$i])) {
                $value = $input['question_type_config_value'][$i] ?? '';
                $value = trim($value);
                $valueArr = $value === '' ? [] : explode(',', $value);

                $questionType->configKeys()->create([
                    'key' => $input['question_type_config_key'][$i],
                    'description' => $input['question_type_config_description'][$i] ?? '',
                    'is_required' => isset($input['question_type_config_is_require'][$i]) ? 1 : 0,
                    'value' => json_encode($valueArr)
                ]);
            }
        }
        return redirect()->route('admin.question-type.index')->with('success', 'Cập nhật loại câu hỏi thành công');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $question_type = QuestionType::find($request->input('del-object-id'));
        try {
            $question_type->delete();
            return redirect()->route('admin.question-type.index')->with('success', 'Xóa loại câu hỏi "'.$question_type->name.'" thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.folder.index')->with('error', 'Gặp lỗi: ' . $e->getMessage());
        }
    }
}
