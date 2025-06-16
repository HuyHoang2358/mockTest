<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['user_id', 'avatar', 'phone', 'birthday', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
