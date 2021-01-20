<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reply;
use App\Models\Recipe;

class Comment extends Model
{
    use HasFactory;


    protected $fillable = [
        'content', 
        'user_id', 
        'recipe_id'
    ];


    //relationship: a comment can have many replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    //inverse relationship: a comment belongs to a recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
