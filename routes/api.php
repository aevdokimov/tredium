<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

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

Route::controller(ArticleController::class)->group(function () {
    Route::get('/', 'homePage');
    Route::get('/articles', 'index');
    Route::get('/articles/{slug}', 'show');
    Route::get('/tags/{slug}', 'byTag');
    Route::get('/view-article/{article}', 'addView');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/comments/create', 'create');
});

Route::controller(LikeController::class)->group(function () {
    Route::get('/likes/like/{article}', 'like');
    Route::get('/likes/unlike/{article}', 'unlike');
});
