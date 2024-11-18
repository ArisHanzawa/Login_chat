<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [ChatController::class, 'index'])->name('chat.chat');
Route::get('/chat', [ChatController::class, 'index'])->name('chat.chat');
Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
Route::post('/chat/store', [ChatController::class, 'store'])->name('chat.store');
Route::post('/subscribe', [NotificationController::class, 'subscribe']);
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
