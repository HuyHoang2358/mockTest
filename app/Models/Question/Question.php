<?php

namespace App\Models\Question;

use App\Models\UserAnswerHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static find($question_id)
 * @method static create(array $data)
 * @method static whereIn(string $string, array $questionIdsToDelete)
 */
class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'question_group_id',
        'number',
        'name',
        'score',
        'content',
        'input_type',
        'question_type_id',
        'attached_file',
    ];

    public function questionGroup() :BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class, 'question_group_id');
    }

    public function answers() :HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
    public function questionType() :BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function myAnswer(): HasOne
    {
        return $this->hasOne(UserAnswerHistory::class, 'question_id');
    }

}
