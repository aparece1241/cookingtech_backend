<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Recipe;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'stars',
        'user_id',
        'recipe_id'
    ];


    //inverse relationship: Rating belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //inverse relationship: Rating belongs to recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}
