<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/app_user/{id}', [AppUserController::class, 'app_user'])->name('al.app_user');
Route::get('/play_chara_gacha/{id}', [AppUserController::class, 'play_chara_gacha'])->name('al.play_chara_gacha');
Route::get('/play_item_gacha/{id}', [AppUserController::class, 'play_item_gacha'])->name('al.play_item_gacha');
Route::get('/show_has_item/{id}', [AppUserController::class, 'show_has_item'])->name('al.show_has_item');

Route::get('/', function () {
    return view('welcome');
});
