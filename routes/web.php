<?php

use App\Http\Controllers\Member\ChatController;
use App\Http\Controllers\Member\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\LoginController;

// include __DIR__ . '/manager.php';
// include __DIR__ . '/admin.php';

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])
->middleware('guest:users')->name('index');

Route::prefix('/member')
->controller(LoginController::class)
->name('members.')
->group(function() {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('accountstore');
    Route::post('/login', 'login')->name('login');
});

Route::post('/member/logout', [LoginController::class, 'logout'])->middleware('auth:users')
->name('members.logout');

Route::prefix('/members')
->middleware('auth:users')
->controller(HomeController::class)
->name('members.')
->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::post('/dashboard', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/edit/{id}', 'update')->name('update');
    Route::get('callender', 'show')->name('callender');
    Route::put('/complete/{id}', 'complete')->name('complete');

});

Route::prefix('/members')
->middleware('auth:users')
->controller(ChatController::class)
->name('members.')
->group(function() {
    Route::get('/chatview/{id}', 'chatView')->name('chatview');
    Route::post('/chatview/{id}', 'sendMessage')->name('sendmessage'); 
});

