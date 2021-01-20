<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;


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


Route::group(['middleware'=>'auth:sanctum'], function() {
    Route::get('/logout', [UserController::class, 'logout']);

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
