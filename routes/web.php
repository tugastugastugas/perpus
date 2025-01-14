<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WahanaController;
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
Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/user/update', [UserController::class, 'updateDetail'])->name('update.user');
Route::delete('/user-destroy/{id_user}', [UserController::class, 'user_destroy'])->name('user.destroy');
Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('detail');

// ROUTE WAHANA
Route::get('/wahana', [WahanaController::class, 'wahana'])
->middleware('check.permission:play')
    ->name('wahana');
Route::post('/t_wahana', [WahanaController::class, 't_wahana'])->name('t_wahana');
Route::post('/wahana/update', action: [WahanaController::class, 'updateDetail'])->name('update.wahana');
Route::delete('/wahana-destroy/{id_wahana}', [WahanaController::class, 'wahana_destroy'])->name('wahana.destroy');
Route::get('/wahana/detail/{id}', [WahanaController::class, 'e_wahana'])
->middleware('check.permission:play')
->name('e_wahana');

// ROUTE BOOKING
Route::get('/booking', [BookingController::class, 'booking'])
->middleware('check.permission:play')
    ->name('booking');
Route::post('/t_anak', [BookingController::class, 't_anak'])->name('t_anak');
Route::delete('/play-destroy/{id_play}', [BookingController::class, 'play_destroy'])->name('play.destroy');
Route::post('/update-status/{id}', [BookingController::class, 'updateStatus']);
Route::get('/transaksi/data/{id_play}', [BookingController::class, 'getData'])->name('transaksi.data');
Route::post('/transaksi/store', [BookingController::class, 'store'])->name('transaksi.store');
Route::get('/send-whatsapp/{id_play}', [BookingController::class, 'sendWhatsapp']);
Route::post('/play/add-time', [BookingController::class, 'addTime'])->name('play.addTime');

// ROUTE LAPORAN TRANSAKSI
Route::get('/transaksi', [TransaksiController::class, 'transaksi'])
->middleware('check.permission:play')
    ->name('transaksi');
Route::post('/t_transaksi', [TransaksiController::class, 't_transaksi'])->name('t_transaksi');
Route::post('/transaksi/update', action: [TransaksiController::class, 'updateDetail'])->name('update.transaksi');
Route::delete('/transaksi-destroy/{id_transaksi}', [TransaksiController::class, 'transaksi_destroy'])->name('transaksi.destroy');
Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'e_transaksi'])->name('e_transaksi');

Route::get('/transaksi/print', [TransaksiController::class, 'print'])->name('transaksi.print');

