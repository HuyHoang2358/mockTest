<?php

namespace App\Models\Question;

use App\Models\Part;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find(mixed $idToDelete)
 * @method static create(array $data)
 * @method static whereIn(string $string, array $idsToDelete)
 * @property mixed $questions
 * @property mixed $id
 * @property mixed $part_id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $content
 * @property mixed $answer_content
 * @property mixed $attached_file
 * @property mixed $answer_inside_content
 */
class QuestionGroup extends Model
{
    protected $table = 'question_groups';

    protected $fillable = [
        'part_id',
        'name',
        'description',
        'content',
        'answer_content',
        'attached_file',
        'answer_inside_content'
    ];
    protected $appends = ['score', 'num_question'];

    // Mối quan hệ 1 nhiều với Part -> trả về đối tượng là phần mà nhóm câu hỏi thuộc về
    public function part() :BelongsTo
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
    public function questions() :HasMany
    {
        return $this->hasMany(Question::class, 'question_group_id');
    }

    public function getAttachedFileAttribute($value): ?array
    {
        if (is_null($value) || trim($value) === '') {
            return null;
        }
        return json_decode($value, true);
    }

    public function getScoreAttribute() :int
    {
        $questions = $this->questions()->get();
        $totalScore = 0;
        foreach ($questions as $question) $totalScore += $question->score;

        return $totalScore;

    }
    public function getNumQuestionAttribute(): int
    {
        return $this->questions()->count();
    }
}
