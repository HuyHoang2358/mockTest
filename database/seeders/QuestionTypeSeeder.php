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
                    ['key' => 'is_shuffle', 'description' => 'Xáo trộn đáp án?', 'value' => json_encode([true,false]), 'is_required' => true],
                    ['key' => 'label', 'description' => 'Kiểu nhãn: A-Z, 1-9, T-F, T-F-N', 'value' =>  json_encode(['A-Z','1-9','T-F','T-F-N']), 'is_required' => true],
                    ['key' => 'num_answer', 'description' => 'Số lượng đáp án', 'value' => null, 'is_required' => true],
                ]
            ],
            [
                'name' => 'Câu hỏi nhiều đáp án',
                'description' => 'Chọn nhiều đáp án',
                'configs' => [
                    [
                        'key' => 'is_shuffle',
                        'description' => 'Xáo trộn đáp án?',
                        'value' => json_encode([true, false]),
                        'is_required' => true
                    ],
                    [
                        'key' => 'label',
                        'description' => 'Kiểu nhãn: A-Z, 1-9',
                        'value' => json_encode(['A-Z', '1-9']),
                        'is_required' => true
                    ],
                    [
                        'key' => 'num_answer',
                        'description' => 'Số lượng đáp án',
                        'value' => null,
                        'is_required' => true
                    ],
                ]
            ],
            [
                'name' => 'Câu hỏi nối đáp án',
                'description' => 'Nối giữa các cột hoặc kéo thả',
                'configs' => [
                    [
                        'key' => 'num_answer',
                        'description' => 'Số lượng đáp án',
                        'value' => null,
                        'is_required' => true
                    ],
                    [
                        'key' => 'label',
                        'description' => 'Kiểu nhãn: A-Z, 1-9',
                        'value' => json_encode(['A-Z', '1-9']),
                        'is_required' => true
                    ],
                    [
                        'key' => 'type',
                        'description' => 'Loại nối: Table | Drag & Drop',
                        'value' => json_encode(['table', 'drag_drop']),
                        'is_required' => true
                    ],
                ]
            ]
        ];

        foreach ($types as $type) {
            $questionType = QuestionType::create([
                'name' => $type['name'],
                'description' => $type['description'],
            ]);

            foreach ($type['configs'] as $config) {
                QuestionTypeConfigKey::create([
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
