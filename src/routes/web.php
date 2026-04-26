<?php

use App\Http\Controllers\GreetingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 文字列を返すルート
Route::get('/hello', function () {
    return 'Hello, Laravel!';
});

// Viewを返すルート
Route::get('/about', function () {
    return view('about');
});

// 挨拶ページ
Route::get('/greeting', [GreetingController::class, 'index']);
Route::post('/greeting', [GreetingController::class, 'store']);
