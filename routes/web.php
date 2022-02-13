<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/tweets', [TweetController::class, 'index'])->name('home');
    Route::post('/tweets', [TweetController::class, 'store']);

    Route::post('/profiles/{user:name}/follow', [FollowController::class, 'store']);

    Route::get('/profiles/{user:name}/edit', [ProfileController::class, 'edit'])->middleware('can:edit,user');
});

Route::get('/profiles/{user:name}', [ProfileController::class, 'show'])->name('profile');

Auth::routes();

