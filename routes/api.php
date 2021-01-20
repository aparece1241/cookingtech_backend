<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RatingController;
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

//routes that doesn't need authenticated user
Route::post('/users/login', [UserController::class, 'login']);
Route::get('/recipes/{id}', [RecipeController::class, 'searchById']);
Route::get('/recipes', [RecipeController::class, 'index']);


//routes for the outhenticated user
Route::group(['middleware'=>'auth:sanctum'], function() {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::post('/replies', [ReplyController::class,'store']);
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::get('/user/bookmarks/{id}', [UserController::class, 'getBookmarks']);
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy']);
});

//routes for authenticated and chef master type user
Route::group(['middleware'=>['auth:sanctum','is_master']], function() {
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
});

//routes for admin users
Route::group(['middleware'=>['auth:sanctum','is_admin']], function () {

});



//user routes
// Route::get('/users/bookmarks/{id}', [UserController::class, 'getBookmarks']);
// Route::apiResource('/users', UserController::class);
// Route::get('users/recipe/{id}', [UserController::class, 'getUserByIdAnd']);


// //Comment routes
// Route::apiResource('/comments', CommentController::class);

// //bookmark routes
// Route::apiResource('/bookmarks', BookmarkController::class);

// //recipe routes
// Route::apiResource('/recipes', RecipeController::class);
// Route::post('/test',[RecipeController::class,"testData"]);
// Route::get('/search/{id}',[RecipeController::class,"searchById"]);
// Route::get('/search/{tag}/tag',[RecipeController::class,"searchbyTag"]);
