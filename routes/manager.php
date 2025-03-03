<?php

use App\Http\Controllers\Manager\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\LoginController;
use App\Http\Controllers\Manager\HomeController;

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

//manager認証

Route::get('/manager',[LoginController::class, 'index'])
->middleware('guest:manager')->name('manager.index');

Route::prefix('/manager')
->controller(LoginController::class)
->name('manager.')
->group(function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::prefix('/manager')
->middleware('auth:manager')
->controller(HomeController::class)
->name('manager.')
->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/callender', 'show')->name('callender');
    Route::delete('/dashboard/{id}', 'destroy')->name('delete');
    
});

Route::prefix('/manager')
->middleware('auth:manager')
->controller(ChatController::class)
->name('manager.')
->group(function () {
    Route::get('/chatview/{id}', 'chatView')->name('chatview');
    Route::post('/chatview/{id}', 'sendMessage')->name('sendmessage');
    Route::put('/chatview/{id}', 'sendBack')->name('sendBack');
});