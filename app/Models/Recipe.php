<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        "name","description","ingredients","procedure","tag","category","yield","video","img"
    ];

    protected $casts=[
        "ingredients"=>"array",
        "procedure"=>"array",
        "img"=>"array",
        "tag"=>"array"
    ];

}
