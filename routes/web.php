<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RestoreEditController;
use App\Http\Controllers\RestoreDeleteController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransaksiController;

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

Route::get('/dashboard', [Controller::class, 'dashboard'])
->middleware('check.permission:dashboard')
->name('dashboard');
Route::get('/playground', [Controller::class, 'playground'])
->name('playground');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/aksi_login', [LoginController::class, 'aksi_login'])->name('aksi_login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/tambah_akun', [LoginController::class, 'tambah_akun'])->name('tambah_akun');
Route::get('/captcha', [LoginController::class, 'captcha'])->name('captcha');


// ROUTE SETTING
Route::get('settings', [SettingController::class, 'edit'])
    ->middleware('check.permission:setting')
    ->name('settings.edit');
Route::post('settings', [SettingController::class, 'update'])
    ->name('settings.update');

// ROUTE LOG ACTIVITY
Route::get('log', [LogController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('log');

// ROUTE PERMISSION
Route::get('/user-levels', [UserLevelController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('user.levels');
Route::get('/menu-permissions/{userLevel}', [UserLevelController::class, 'showMenuPermissions'])
    ->name('menu.permissions');
Route::post('/save-permissions', [UserLevelController::class, 'savePermissions'])
    ->name('save.permissions');

// ROUTE RESTORE EDIT
Route::get('/restore_e', [RestoreEditController::class, 'restore_e'])
    ->middleware('check.permission:setting')
    ->name('restore_e');
Route::post('/user/restore/{id_user}', [RestoreEditController::class, 'restoreEdit'])->name('user.restoreEdit');
Route::delete('/user_history/{id_user_history}', [RestoreEditController::class, 're_destroy'])->name('re.destroy');

// ROUTE RESTORE DELETE
Route::get('/restore_d', [RestoreDeleteController::class, 'restore_d'])
    ->middleware('check.permission:setting')
    ->name('restore_d');
Route::post('/user/restore-delete/{id}', [RestoreDeleteController::class, 'user_restore'])->name('user.restore');
Route::delete('/user/{id}', [RestoreDeleteController::class, 'rd_destroy'])->name('rd.destroy');

// ROUTE USER
Route::get('/user', [UserController::class, 'user'])
    ->middleware('check.permission:setting')
    ->name('user');
Route::post('/t_user', [UserController::class, 't_user'])->name('t_user');
Route::post('/t_murid', [UserController::class, 't_murid'])->name('t_murid');
Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/user/update', [UserController::class, 'updateDetail'])->name('update.user');
Route::delete('/user-destroy/{id_user}', [UserController::class, 'user_destroy'])->name('user.destroy');
Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('detail');

// ROUTE kelas
Route::get('/kelas', [KelasController::class, 'kelas'])
    ->name('kelas');
Route::post('/t_kelas', [KelasController::class, 't_kelas'])->name('t_kelas');
Route::post('/kelas/update', action: [KelasController::class, 'updateDetail'])->name('update.kelas');
Route::delete('/kelas-destroy/{id_kelas}', [KelasController::class, 'kelas_destroy'])->name('kelas.destroy');
Route::get('/kelas/detail/{id}', [KelasController::class, 'e_kelas'])
->name('e_kelas');


// ROUTE kategori
Route::get('/kategori', [KategoriController::class, 'kategori'])
    ->name('kategori');
Route::post('/t_kategori', [KategoriController::class, 't_kategori'])->name('t_kategori');
Route::post('/kategori/update', action: [KategoriController::class, 'updateDetail'])->name('update.kategori');
Route::delete('/kategori-destroy/{id_kategori}', [KategoriController::class, 'kategori_destroy'])->name('kategori.destroy');
Route::get('/kategori/detail/{id}', [KategoriController::class, 'e_kategori'])
->name('e_kategori');
