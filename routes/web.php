<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-page',[LoginController::class,'loginPage'])->name('login.page');
Route::get('/login',[LoginController::class,'login'])->name('login');

Route::middleware(['user.login'])->group(function () {
    Route::get('/home',[HomeController::class,'home'])->name('home');
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
});
