<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use App\Models\Category;
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
Route::get('posts', [PostController::class, 'index'])->name('posts');
Route::get('like/{id}', [PostController::class, 'like'])->name('like');
Route::get('post/id{id}', [PostController::class, 'show'])->name('post');

Route::get('categories', [CategoryController::class, 'index']);


Route::get("user/id{id}", [UserController::class, 'show'])->name('user_show');


Route::post('login', [AuthController::class, 'login']);
Route::post('registration', [AuthController::class, 'register']);


Route::get('categories', [AdminController::class, 'index']);
Route::post('categories/delete/id{id}', [AdminController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function() {
    Route::get('chats', [ChatController::class, 'index'])->name("chats");
    Route::get('chat/id{id}', [ChatController::class, 'show'])->name("chat");

    Route::post("search", [SearchController::class, 'index'])->name('search');

    Route::post('createChat/id{id}', [ChatController::class, 'createChat']);
    Route::post("message/chat/id{id}", [ChatController::class, 'message']);
    Route::get("message/delete/id{id}", [ChatController::class, 'destroy']);

    Route::get('posts/my', [PostController::class, 'my']);
    Route::post('posts/create', [PostController::class, 'store']);
    Route::get('update/post/id{id}', [PostController::class, 'update']);

    // Route::get('categories', [AdminController::class, 'index']);

    Route::get('profile', [UserController::class, 'index']);
    Route::get('profile/friends', [UserController::class, 'friends']);
    Route::put('profile/id{id}/update/', [UserController::class, 'update']);
    Route::post("send-friend/id{id}", [UserController::class, 'store'])->name("addFriend");
    Route::get('logout', [AuthController::class, 'logout']);
});
