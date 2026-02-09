<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});


//Route::get('/main', [MainController::class, 'index']);

Route::get('/main/{value}', [MainController::class, 'index']);

Route::get('/page2/{value}', [MainController::class, 'page2']);
Route::get('/page3/{value}', [MainController::class, 'page3']);

Route::get('/login', [AuthController::class, 'login']);
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
Route::get('/logout', [AuthController::class, 'logout']);


