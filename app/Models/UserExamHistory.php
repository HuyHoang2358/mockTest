<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int $param)
 * @method static create(array $array)
 * @method static find($userExamHistoryId)
 */
class UserExamHistory extends Model
{
    protected $table = 'user_exam_histories';

    protected $fillable = [
        'user_id',
        'guest_id',
        'user_name',
        'exam_id',
        'start_at',
        'end_at',
        'status',
        'score',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
