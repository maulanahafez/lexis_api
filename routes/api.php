<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function () {
    Route::post('user', 'index');
    Route::get('user/username_unique', 'is_username_unique');

    // User Stories
    Route::get('user/{id}/stories', 'getUserStories');
});

Route::controller(StoryController::class)->group(function () {
    // Readers
    Route::get('stories', 'index');

    // Authors
    Route::post('stories', 'store');
    Route::get('stories/{id}', 'show');
    Route::patch('stories/{id}', 'update');
    Route::delete('stories/{id}', 'destroy');
});

Route::controller(ChapterController::class)->group(function () {
    // Authors
    Route::post('chapters', 'store');
    Route::patch('chapters/{id}', 'update');
    Route::delete('chapters/{id}', 'destroy');

    // Readers
    Route::get('stories/{id}/chapters', 'index');
    Route::get('chapters/{id}', 'show');

    // Comments
    Route::get('chapters/{id}/comments', 'getComments');

    // Likes
    Route::get('chapters/{id}/likes', 'getLikes');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('comments', 'store');
    Route::patch('comments/{id}', 'update');
    Route::delete('comments/{id}', 'destroy');
});

Route::controller(LikeController::class)->group(function () {
    Route::post('likes', 'store');
    Route::delete('likes/{id}', 'destroy');
});

Route::controller(FollowController::class)->prefix('follow')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});
