<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('messages', [App\Http\Controllers\HomeController::class, 'messages'])->name('messages');
Route::post('message', [App\Http\Controllers\HomeController::class, 'message'])->name('message');
