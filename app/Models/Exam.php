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
        'status'
    ];

    protected $appends = ['time'];
    public function folder() :HasOne
    {
        return $this->hasOne(Folder::class, 'id', 'folder_id');
    }
    public function parts() :HasMany
    {
        return $this->hasMany(Part::class, 'exam_id', 'id');
    }

    public function getTimeAttribute()
    {
        $parts = $this->parts()->get();
        $num = 0;
        foreach ($parts as $part) $num = $num + $part->time;
        return $num;
    }
}
