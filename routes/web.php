<?php

use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/top', [TopController::class,'top']);

Route::get('/register', [TopController::class,'register']);

Route::post('/register-user', [TopController::class,'registerUser']);

Route::get('/user-list', [TopController::class,'userList']);

Route::get('/register-success', [TopController::class,'registerSuccess']);

Route::get('/login',[TopController::class,'login']);

Route::post('/login',[TopController::class,'login']);

Route::get('/logout',[TopController::class,'logout']);

Route::get('/user-update',[TopController::class,'userUpdate']);

Route::post('/user-update-result',[TopController::class,'userUpdateResult']);

Route::any('/email-update',[TopController::class,'emailUpdate']);
Route::any('/password-update',[TopController::class,'passwordUpdate']);
Route::any('/postcode-update',[TopController::class,'postcodeUpdate']);
Route::any('/prefecture-update',[TopController::class,'prefectureUpdate']);
Route::any('/city-update',[TopController::class,'cityUpdate']);
Route::any('/tel-update',[TopController::class,'telUpdate']);
Route::any('/name-update',[TopController::class,'nameUpdate']);
Route::any('/address-update',[TopController::class,'addressUpdate']);

Route::get('/bento-manage',[TopController::class,'bentoManage']);
Route::get('/bento-add',[TopController::class,'bentoAdd']);
Route::post('/bento-add-success',[TopController::class,'bentoAddSuccess']);
Route::post('/bento-update',[TopController::class,'bentoUpdate']);
Route::post('/bento-update-success',[TopController::class,'bentoUpdateSuccess']);
Route::post('/bento-delete',[TopController::class,'bentoDelete']);

Route::get('/users-delete',[TopController::class,'usersDelete']);
Route::post('/users-delete-action',[TopController::class,'usersDeleteAction']);
Route::post('/users-delete-success',[TopController::class,'usersDeleteSuccess']);
Route::get('/users-delete-complete',[TopController::class,'bentoDeleteComplete']);


Route::get('bento-buy-top',[TopController::class,'bentoBuyTop']);
Route::post('bento-buy-confirm',[TopController::class,'bentoBuyConfirm']);
Route::post('bento-buy-success',[TopController::class,'bentoBuySuccess']);
