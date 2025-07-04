<?php

namespace Database\Seeders;

use App\Models\Question\QuestionType;
use App\Models\Question\QuestionTypeConfigKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Câu hỏi 1 đáp án',
                'description' => 'Câu hỏi chỉ chọn 1 đáp án',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' =>  json_encode(['radio']), 'is_required' => true],
                    ['key' => 'label', 'description' => 'Kiểu nhãn: A-Z, 1-9, T-F, T-F-N', 'value' =>  json_encode(['A-Z','i-x','T-F','T-F-N']), 'is_required' => true],
                    ['key' => 'num_answer', 'description' => 'Số lượng đáp án', 'value' => null, 'is_required' => true],
                ]
            ],
            [
                'name' => 'Câu hỏi nhiều đáp án',
                'description' => 'Chọn nhiều đáp án',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' =>  json_encode(['checkbox']), 'is_required' => true],
                    ['key' => 'label', 'description' => 'Kiểu nhãn: A-Z, i-x', 'value' => json_encode(['A-Z', 'i-x']), 'is_required' => true],
                    ['key' => 'num_answer', 'description' => 'Số lượng đáp án', 'value' => null, 'is_required' => true],
                ]
            ],
            [
                'name' => 'Chọn đáp án từ 1 danh sách',
                'description' => 'Chọn đáp án từ 1 danh sách các đáp án',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' =>  json_encode(['select']), 'is_required' => true],
                    ['key' => 'num_answer', 'description' => 'Số lượng đáp án', 'value' => null, 'is_required' => true],
                    ['key' => 'label', 'description' => 'Kiểu nhãn: A-Z, i-x', 'value' => json_encode(['A-Z', 'i-x']), 'is_required' => true],

                ]
            ],
            [
                'name' => 'Điền từ vào chỗ trống',
                'description' => 'Điền đáp án vào chỗ trống trong câu trả lời',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' =>  json_encode(['text']), 'is_required' => true],
                    ['key' => 'max_word', 'description' => 'Số lượng từ tối đa', 'value' => null, 'is_required' => true],
                ]
            ],
            [
                'name' => 'Viết đoạn văn',
                'description' => 'Viết đoạn văn ngắn',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' => json_encode(['textarea']), 'is_required' => true],
                    ['key' => 'max_word', 'description' => 'Số lượng từ tối đa', 'value' => null, 'is_required' => true],
                ]
            ],
            [
                'name' => 'Viết bài văn văn',
                'description' => 'Viết bài văn',
                'configs' => [
                    ['key' => 'input_type', 'description' => 'Kiểu trả lời?', 'value' =>  json_encode(['textarea']), 'is_required' => true],
                    ['key' => 'max_word', 'description' => 'Số lượng từ tối đa', 'value' => null, 'is_required' => true],
                ]
            ],

        ];

        foreach ($types as $type) {
            $questionType = QuestionType::updateOrCreate([
                'name' => $type['name']
            ],
            [
                'name' => $type['name'],
                'description' => $type['description'],
            ]);

            foreach ($type['configs'] as $config) {
                QuestionTypeConfigKey::updateOrCreate([
                    'question_type_id' => $questionType->id,
                    'key' => $config['key'],
                ],[
                    'question_type_id' => $questionType->id,
                    'key' => $config['key'],
                    'description' => $config['description'],
                    'value' => $config['value'],
                    'is_required' => $config['is_required'],
                ]);
            }
        }
    }
}
