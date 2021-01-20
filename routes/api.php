<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReplyController;


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
    Route::get('/logout', [UserController::class, 'logout']);
});



//user routes
Route::get('/users/bookmarks/{id}', [UserController::class, 'getBookmarks']);
Route::post('login', [UserController::class, 'login']);
Route::apiResource('/users', UserController::class);
Route::get('users/recipe/{id}', [UserController::class, 'getUserByIdAnd']);


//Comment routes
Route::apiResource('/comments', CommentController::class);

//bookmark routes
Route::apiResource('/bookmarks', BookmarkController::class);

//recipe routes
Route::apiResource('/recipes', RecipeController::class);
Route::post('/test',[RecipeController::class,"testData"]);
Route::get('/search/{id}',[RecipeController::class,"searchById"]);
Route::get('/search/{tag}/tag',[RecipeController::class,"searchbyTag"]);
Route::get('/search/{category}/cat',[RecipeController::class,"searchbyCategory"]);



//reply routes

Route::apiResource('/replies',ReplyController::class);