<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'comment_id'
    ];


    //inverse relationship: reply belongs to a comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    //inverse relationship: reply belongs to a user
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
