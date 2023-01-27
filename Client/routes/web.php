<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\Pemasukkan;
use App\Http\Controllers\Pengeluaran;
use App\Http\Controllers\user;
use App\Http\Controllers\Login;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HutangController;

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
Route::get('/laporan/pdf', [Laporan::class, 'pdf']);
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
Route::get('/deletephoto',[Profile::class, 'deletephoto'])->middleware('authCustom');
Route::get('/user/filteruser',[User::class, 'filteruser'])->middleware('authCustom');
Route::get('/user/detailuser',[User::class, 'detailuser'])->middleware('authCustom');
Route::get('/laporan/umum',[Laporan::class, 'laporan_umum'])->middleware('authCustom');
Route::post('/laporan/umum',[Laporan::class, 'laporan_umum'])->middleware('authCustom');
Route::get('/laporan/umum/pdf',[Laporan::class, 'pdf_umum']);
Route::get('/laporan/umum/qrcode',[Laporan::class, 'qrcode_umum'])->middleware('authCustom');
Route::post('/pemasukkan/deleteSelected',[Pemasukkan::class, 'deleteSelectedData'])->middleware('authCustom');
Route::get('/flash',[Pemasukkan::class, 'set_session']);
Route::post('/pengeluaran/deleteSelected',[Pengeluaran::class, 'deleteSelectedData'])->middleware('authCustom');
Route::get('/pemasukkan/tambahdata',[Pemasukkan::class, 'create'])->middleware('authCustom');
Route::get('/pengeluaran/tambahdata',[Pengeluaran::class, 'create'])->middleware('authCustom');
Route::get('/hutang',[HutangController::class, 'index'])->middleware('authCustom');
Route::get('/hutang/hapus_data/{id}',[HutangController::class, 'hapus_data'])->middleware('authCustom');
Route::get('/hutang/{id}',[HutangController::class, 'getHutangById'])->middleware('authCustom');
Route::post('/hutang',[HutangController::class, 'store'])->middleware('authCustom');
Route::post('/hutang/edit_data',[HutangController::class, 'update'])->middleware(('authCustom'));
Route::get('/hutang/lunas/{kode}',[HutangController::class, 'setLunas'])->middleware('authCustom');