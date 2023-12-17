<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
        'image'
    ];

    public function categories() {
        return $this->belongsToMany(Category::class, 'posts_categories');
    }
}
