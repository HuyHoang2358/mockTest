<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'label',
        'value',
        'is_correct',
        'note',
    ];

    // Mối quan hệ với Question
    public function question() :BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
