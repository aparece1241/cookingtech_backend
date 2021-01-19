<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reply;

class Comment extends Model
{
    use HasFactory;


    protected $fillable = [
        'content', 
        'user_id', 
        'recipe_id'
    ];


    //relationship: a comment can have many replies
    public function FunctionName(Type $var = null)
    {
        return $this->hasMany(Reply::class);
    }

}
