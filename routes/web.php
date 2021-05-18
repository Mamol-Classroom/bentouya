<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\BentoController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\OrderController;
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
// ユーザー
Route::get('/register', [TopController::class, 'register']);
Route::post('/register-user', [TopController::class, 'registerUser']);
Route::get('/register-success', [TopController::class, 'registerSuccess']);
Route::get('/login', [TopController::class, 'login']);
Route::post('/login', [TopController::class, 'login']);
Route::get('/logout', [TopController::class, 'logout'])->middleware('auth');
// 弁当
Route::get('/bentos', [BentoController::class, 'index'])->middleware('auth');
Route::get('/bento/add', [BentoController::class, 'add'])->middleware('auth');
Route::post('/bento/add', [BentoController::class, 'add'])->middleware('auth');
Route::get('/bento/add/complete', [BentoController::class, 'addComplete'])->middleware('auth');
Route::post('/bento/delete', [BentoController::class, 'delete'])->middleware('auth');
Route::get('/bento/update', [BentoController::class, 'update'])->middleware('auth');
Route::get('/bento/{bento_id}/detail', [BentoController::class, 'detail'])->middleware('auth');
Route::post('/bento/update', [BentoController::class, 'update'])->middleware('auth');
Route::post('/bento/favourite/add',[BentoController::class,'addfavourite'])->middleware('auth');
// マイページ
Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth');
Route::get('/mypage/update',[MypageController::class,'update'])->middleware('auth');
Route::post('/mypage/update',[MypageController::class,'update'])->middleware('auth');
Route::get('/mypage/password_change',[MypageController::class,'password_change'])->middleware('auth');
Route::post('/mypage/password_change',[MypageController::class,'password_change'])->middleware('auth');
Route::get('/mypage/favourite', [MypageController::class, 'favourite'])->middleware('auth');
Route::post('/mypage/favourite', [MypageController::class, 'favourite'])->middleware('auth');
// 支払い
Route::get('/mydetail',[MypageController::class,'mydetail'])->middleware('auth');
Route::post('/mydetail',[MypageController::class,'mydetail'])->middleware('auth');

Route::get('/cart', [OrderController::class, 'index'])->middleware('auth');
Route::post('/add-to-cart', [OrderController::class, 'addToCart'])->middleware('auth');
