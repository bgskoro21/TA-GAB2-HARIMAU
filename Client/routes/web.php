<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\Pemasukkan;
use App\Http\Controllers\Pengeluaran;
use App\Http\Controllers\user;
use App\Http\Controllers\Login;
use App\Http\Controllers\Profile;
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

Route::get('/', [Dashboard::class, 'index'])->middleware('authCustom');
Route::get('/user', [User::class, 'index'])->middleware('authCustom');
Route::get('/user/dataByUsername/{username}', [User::class, 'dataByUsername'])->middleware('authCustom');
Route::get('/pemasukkan/getPemasukkanById/{id}', [Pemasukkan::class, 'getPemasukkanById'])->middleware('authCustom');
Route::get('/pemasukkan', [Pemasukkan::class, 'index'])->middleware('authCustom');
Route::post('/user/add_data', [User::class, 'add_data'])->middleware('authCustom');
Route::post('/pemasukkan/add_data', [Pemasukkan::class, 'add_data'])->middleware('authCustom');
Route::get('/user/hapus_data/{username}', [User::class, 'hapus_data'])->middleware('authCustom');
Route::get('/pemasukkan/hapus_data/{id}', [Pemasukkan::class, 'hapus_data'])->middleware('authCustom');
Route::post('/user/edit_data', [User::class, 'edit_data'])->middleware('authCustom');
Route::post('/pemasukkan/edit_data', [Pemasukkan::class, 'edit_data'])->middleware('authCustom');
Route::get('/pengeluaran/getPengeluaranById/{id}', [Pengeluaran::class, 'getPengeluaranById'])->middleware('authCustom');
Route::get('/pengeluaran', [Pengeluaran::class, 'index'])->middleware('authCustom');
Route::post('/pengeluaran/add_data', [Pengeluaran::class, 'add_data'])->middleware('authCustom');
Route::get('/pengeluaran/hapus_data/{id}', [Pengeluaran::class, 'hapus_data'])->middleware('authCustom');
Route::post('/pengeluaran/edit_data', [Pengeluaran::class, 'edit_data'])->middleware('authCustom');
Route::get('/laporan',[Laporan::class, 'index'])->middleware('authCustom');
Route::get('/laporan/harian',[Laporan::class, 'index'])->middleware('authCustom');
Route::get('/laporan/pdf', [Laporan::class, 'pdf'])->middleware('authCustom');
Route::get('/laporan/qrcode', [Laporan::class, 'qrcode'])->middleware('authCustom');
Route::get('/login',[Login::class, 'index'])->name('login');
Route::post('/login',[Login::class, 'authenticate']);
Route::get('/logout',[Login::class, 'logout']);
Route::get('/profile',[Profile::class, 'index']);
Route::post('/profile/edit_profile',[Profile::class, 'edit_profile'])->middleware('authCustom');
Route::post('/profile/change_password',[Profile::class, 'change_password'])->middleware('authCustom');
Route::post('/forgotpassword',[Login::class, 'sendForgot']);
Route::get('/login/verifikasi', [Login::class, 'verifikasi']);
Route::get('/forgotpassword', [Login::class, 'forgotPassword']);
Route::get('/changepassword', [Login::class, 'changePassword']);
Route::get('/resetpassword', [Login::class, 'view_reset']);
Route::post('/resetpassword', [Login::class, 'resetPassword']);
Route::get('/getSaldo',[Dashboard::class, 'getSaldo'])->middleware('authCustom');
Route::get('/getPemasukkan',[Dashboard::class, 'getPendapatan'])->middleware('authCustom');
Route::get('/getPengeluaran',[Dashboard::class, 'getPengeluaran'])->middleware('authCustom');
Route::get('/expToken',[Login::class, 'expToken'])->middleware('authCustom');