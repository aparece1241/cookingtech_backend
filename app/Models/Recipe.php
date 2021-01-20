<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\User;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "ingredients",
        "procedures",
        "tag",
        "category",
        "yield",
        "video_url",
        "img_url",
        "user_id"
    ];

    protected $casts=[
        "ingredients"=>"array",
        "procedures"=>"array",
        "img"=>"array",
        "tag"=>"array"
    ];


    //relationships: a recipe can have many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //relationship: a recipe can have many ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    } 

    //inverse relationship: recipe belongs to the a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}