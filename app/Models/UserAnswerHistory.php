<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static updateOrCreate(array $array)
 */
class UserAnswerHistory extends Model
{
    protected $table = 'user_answer_histories';

    protected $fillable = [
        'user_id',
        'guest_id',
        'user_name',
        'exam_id',
        'question_id',
        'is_correct', // 0: incorrect, 1: correct, -1: chưa cham
        'answer',
        'note',
        'point',
    ];

}
