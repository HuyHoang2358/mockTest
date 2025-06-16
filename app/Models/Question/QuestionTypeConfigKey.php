<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class QuestionTypeConfigKey extends Model
{
    protected $table = 'question_type_config_keys';

    protected $fillable = [
        'question_type_id',
        'key',
        'description',
        'value',
        'is_required'
    ];

    // Mối quan hệ 1 nhiều với QuestionType -> trả về đối tượng là loại câu hỏi mà cấu hình này thuộc về
    public function questionType() :BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }
}
