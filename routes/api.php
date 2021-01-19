<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:sanctum'], function() {

});

Route::post('login', [UserController::class, 'login']);
Route::apiResource('/recipes', RecipeController::class);
Route::apiResource('/users', UserController::class);



Route::post('/test',[RecipeController::class,"testData"]);
Route::get('/search/{id}',[RecipeController::class,"searchById"]);
Route::get('/search/{category}/cat',[RecipeController::class,"searchbyCategory"]);
Route::get('/search/{tag}/tag',[RecipeController::class,"searchbyTag"]);

