<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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

Route::get('chats', [ChatController::class, 'index'])->name("chats");
Route::get('chat/id{id}', [ChatController::class, 'show'])->name("chat");

Route::get("user/id{id}", [UserController::class, 'show'])->name('user_show');

Route::post("search_people", [UserController::class, 'search'])->name('search_people');
Route::post("addFriend", [UserController::class, 'store'])->name("addFriend");

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
