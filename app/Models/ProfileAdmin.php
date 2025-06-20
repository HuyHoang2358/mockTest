<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileAdmin extends Model
{
    protected $table = 'profile_admins';
    protected $fillable = ['admin_id', 'avatar', 'phone', 'birthday', 'address'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
