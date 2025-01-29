<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'body',
        'image',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke tabel images agar user bisa menambahkan lebih dari image
    public function images():HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    // relasi untuk likePost
    public function likedByUsers():BelongsToMany {
        return $this->belongsToMany(User::class, 'post_like_user')->withTimestamps();
    }

    // relasi komenan orang pada postingan
    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }


    // relasi ke tabel bookmark
    public function bookmarksByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    // relasi ke tabel hashtag
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class, 'hashtag_posts');
    }

}
