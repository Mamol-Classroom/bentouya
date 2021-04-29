<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;

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
Route::get('/', [TopController::class, 'top']);

Route::get('/register', [TopController::class, 'register']);
Route::post('/register-user', [TopController::class, 'registerUser']);
Route::get('/register-success', [TopController::class, 'registerSuccess']);
Route::get('/login', [TopController::class, 'login']);
Route::post('/login', [TopController::class, 'login']);
Route::get('/logout', [TopController::class, 'logout']);
