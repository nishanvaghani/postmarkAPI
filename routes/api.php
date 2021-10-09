<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-mail',[UserController::class,'sendMail'])->name('send.mail');
Route::post('user-email-update', [UserController::class,'changeUserEmail'])->name('change-user-email');
