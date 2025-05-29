<?php

use App\Http\Controllers\Admin\AdminController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
->middleware('guest:admin')->group(function() {
  Route::get('/', [AdminController::class, 'loginForm'])->name('admin.loginForm');
  Route::post('/', [AdminController::class, 'login'])->name('admin.login');
});

Route::prefix('admin')
->middleware('auth:admin')
->controller(AdminController::class)
->group(function() {
  Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
  Route::post('/migrate', 'migrate')->name('admin.migrate');
  Route::post('/logout', 'logout')->name('admin.logout');
});
