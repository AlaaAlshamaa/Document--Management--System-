<?php

namespace App\Models;

use App\Http\Traits\Loggable;
use App\Http\Traits\Notificatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    use HasFactory, Loggable, Notificatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     *  touched if update
     */
    protected $touches = [
        'documents',
        'comments'
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'category_id', 'id');
    }
    
        public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
