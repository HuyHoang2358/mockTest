<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static orderBy(string $string, string $string1)
 * @method static find(mixed $input)
 */
class QuestionType extends Model
{
    protected  $table = 'question_types';
    protected $fillable = [
        'name',
        'description',
    ];

    // Mối quan hệ 1 nhiều với QuestionTypeConfigKey -> trả về tất cả các cấu hình của loại câu hỏi này dưới dạng mảng
    public function configKeys():HasMany
    {
        return $this->hasMany(QuestionTypeConfigKey::class, 'question_type_id');
    }

}
