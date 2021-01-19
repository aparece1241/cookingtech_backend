<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Rating;

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
        "video",
        "img",
        "user_id"
    ];

    protected $casts=[
        "ingredients"=>"array",
        "procedure"=>"array",
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

}