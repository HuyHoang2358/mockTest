<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static pluck(string $string)
 * @method static find($id)
 * @method static where(string $string, $id)
 * @method static orderBy(string $string, string $string1)
 * @property mixed $name
 * @property mixed $status
 */
class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = [
        'folder_id',
        'name',
        'code',
        'total_time',
        'start_time',
        'end_time',
        'password',
        'price',
        'url_excer',
        'url_todo',
        'qr_code_excer',
        'qr_code_todo',
        'is_payment',
        'number_of_todo',
        'status',
        'time'
    ];

    protected $appends = ['total_part_time', 'total_question'];
    public function folder() :HasOne
    {
        return $this->hasOne(Folder::class, 'id', 'folder_id');
    }
    public function parts() :HasMany
    {
        return $this->hasMany(Part::class, 'exam_id', 'id');
    }

    public function getTotalPartTimeAttribute()
    {
        $parts = $this->parts()->get();
        $num = 0;
        foreach ($parts as $part) $num = $num + $part->time;
        return $num;
    }
    public function getTotalQuestionAttribute()
    {
        $parts = $this->parts()->get();
        $num = 0;
        foreach ($parts as $part) {
            $num += $part->num_question;
        }
        return $num;
    }

    public function userExamHistories() :HasMany
    {
        return $this->hasMany(UserExamHistory::class, 'exam_id', 'id');
    }
    public function checkedUserExamHistories() :HasMany
    {
        return $this->userExamHistories()->where('status', 'CHECKED');
    }
    public function checkingUserExamHistories() :HasMany
    {
        return $this->userExamHistories()->where('status', 'CHECKING');
    }
}
