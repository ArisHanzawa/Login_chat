<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WebPushController;
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/chat', [ChatController::class, 'index'])->name('chat.chat');
Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/webpush', 'webpush')->name('webpush.webpush');

Route::post('/set-subscription', [WebPushController::class, 'setSubscription'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

Route::get('/send', [WebPushController::class, 'send']);

Route::prefix('announcement')->middleware('auth')->group(function(){

    Route::get('/', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/list', [AnnouncementController::class, 'list'])->name('announcement.list');
    Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('announcement.show');

});

require __DIR__.'/auth.php';
