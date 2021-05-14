<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\BentoController;
use App\Http\Controllers\MypageController;
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

//ユーザー
Route::get('/register', [TopController::class, 'register']);
Route::post('/register-user', [TopController::class, 'registerUser']);

Route::get('/register_success', [TopController::class, 'registerSuccess']);
Route::get('/login', [TopController::class, 'login']);
Route::post('/login', [TopController::class, 'login']);
Route::get('/logout', [TopController::class, 'logout'])->middleware('auth');


//弁当

Route::get('/bentos',[BentoController::class,'index'])->middleware('auth');
Route::get('/bento/add', [BentoController::class, 'add'])->middleware('auth');
Route::post('/bento/add', [BentoController::class, 'add'])->middleware('auth');
Route::get('/bento/add/complete', [BentoController::class, 'addComplete'])->middleware('auth');

Route::post('/bento/delete',[BentoController::class, 'delete'])->middleware('auth');
Route::get('/bento/update',[BentoController::class, 'update'])->middleware('auth');
Route::post('/bento/update',[BentoController::class, 'update'])->middleware('auth');

Route::post('/bento/favourite/add',[BentoController::class, 'addFavourite'])->middleware('auth');
//商品详细
//直接通过路由传参数Route::get('/bento/detail',[BentoController::class,'detail']);
Route::get('/bento/detail/{bento_id}',[BentoController::class,'detail']);



//マイページ
Route::get('/mypage',[MypageController::class,'index'])->middleware('auth');
Route::post('/mypage',[MypageController::class,'index'])->middleware('auth');
Route::get('/mypage/password-update',[MypageController::class,'passwordUpdate'])->middleware('auth');
Route::post('/mypage/password-update',[MypageController::class,'passwordUpdate'])->middleware('auth');


Route::get('/favourite',[MypageController::class,'favourite'])->middleware('auth');




//支払い

