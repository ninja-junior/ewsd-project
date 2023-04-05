<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];



    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function isDeletable()
    {
        return $this->posts()->count() === 0;
    }
    
}
