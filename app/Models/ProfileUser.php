<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class ProfileUser extends Model
{
    protected $table = 'profile_users';
    protected $fillable = ['user_id', 'avatar', 'phone', 'birthday', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
