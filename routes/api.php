<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/recipes', RecipeController::class);
Route::post('/test',[RecipeController::class,"testData"]);
Route::get('/search/{id}',[RecipeController::class,"searchById"]);
Route::get('/search/{tag}/tag',[RecipeController::class,"searchbyTag"]);

//index => localhost:port/recipes
//store => localhost:port/recipes
//destroy => localhost:port/recipes/{id}
//update => localhost:port/recipes/{id}
