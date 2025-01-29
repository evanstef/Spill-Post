<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // relasi agar bisa mengambil postingan postingan sesuia dengan hashtagnya
    public function posts() : BelongsToMany {
        return $this->belongsToMany(Post::class, 'hashtag_posts');
    }

}
