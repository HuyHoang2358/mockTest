<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
 * @method static whereNull(string $string)
 * @method static find(mixed $folder_id)
 */
class Folder extends Model
{
    protected $table = 'folders';
    protected $fillable = ['name', 'parent_id'];

    // Lấy thông tin cha cua thư mục hiện tại
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    // Lấy thông tin thư mục con thư mục hiện tại
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
    // Lấy tất cả các thư mục con và cháu của thư mục hiện tại
    public function childrenRecursive(): Builder|HasMany
    {
        return $this->children()->with('childrenRecursive');
    }
}
