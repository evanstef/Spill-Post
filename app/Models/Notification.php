<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'action_by',
        'type',
        'is_read',
    ];

    // relasi mengambil data user
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // relasi mengambil data post
    public function post():BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // relasi like user
    public function actionBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }

}
