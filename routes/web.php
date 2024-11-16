<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/example-page','example-page');
Route::view('/example-auth','example-auth');


// Admin Route

Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest'])->group(function(){
        Route::controller(AuthController::class)->group(function(){
            Route::get('/login','loginForm')->name('login');
            Route::post('/login','loginHandler')->name('login_handler');
            Route::get('/forgot-password','forgotForm')->name('forgot');
        });
    });

    Route::middleware(['auth'])->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');
            Route::post('/logout','logoutHandler')->name('logout');
        });
    });

});