<?php

namespace App\Models;

use App\Models\Question\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find(mixed $input)
 */
class Part extends Model
{

    protected $table = 'parts';
    protected $fillable = ['exam_id', 'name', 'number', 'description', 'time', 'content', 'attached_file', 'part_type'];


    public function exam() :BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
    public function questionGroups() :HasMany
    {
        return $this->hasMany(QuestionGroup::class, 'part_id');
    }
    protected $appends = ['num_question', 'score'];

    public function getNumQuestionAttribute(): int
    {
        $questionGroups = $this->questionGroups()->get();
        $num = 0;
        foreach ($questionGroups as $questionGroup) {
            $num = $num + $questionGroup->num_question;
        }
        return $num;
    }
    public function getScoreAttribute(): int
    {
        $questionGroups = $this->questionGroups()->get();
        $score = 0;
        foreach ($questionGroups as $questionGroup) {
            $score = $score + $questionGroup->score;
        }
        return $score;
    }
}
