<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;


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

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/aksi_login', [LoginController::class, 'aksi_login'])->name('aksi_login');
Route::get('/register', [LoginController::class, 'register'])->name('register');

// ROUTE SETTING
Route::get('settings', [SettingController::class, 'edit'])
    ->name('settings.edit');
Route::post('settings', [SettingController::class, 'update'])
    ->name('settings.update');
