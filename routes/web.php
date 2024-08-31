<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guest\DownloadController;
use App\Http\Controllers\Guest\UploadController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'post'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/guest', [GuestController::class, 'index'])->name('guest.index');
    Route::get('/guest/upload', [UploadController::class, 'index'])->name('guest.upload.index');
    Route::get('/guest/download', [DownloadController::class, 'index'])->name('guest.download.index');
    Route::get('/guest/download/trash', [DownloadController::class, 'trash'])->name('guest.download.trash');
    Route::delete('/guest/download/trash/{file}', [DownloadController::class, 'destroy'])->name('guest.download.destroy');
    Route::get('/guest/download/preview/{file}', [DownloadController::class, 'preview'])->name('guest.download.preview');
    Route::post('/guest/download/restore', [DownloadController::class, 'restore'])->name('guest.download.restore');
    Route::post('/guest/download/rename', [DownloadController::class, 'rename'])->name('guest.download.rename');
    Route::post('/guest/download/delete', [DownloadController::class, 'delete'])->name('guest.download.delete');
    Route::post('/guest/download/deletes', [DownloadController::class, 'deletes'])->name('guest.download.deletes');
    Route::post('/guest/download/download', [DownloadController::class, 'download'])->name('guest.download.download');
    Route::post('/guest/download/downloads', [DownloadController::class, 'downloads'])->name('guest.download.downloads');
});

Route::middleware('auth')->name('admin.')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('index');
    Route::post('/admin/request', [RequestController::class, 'store'])->name('request.store');
    Route::get('/admin/request/download/{file}', [RequestController::class, 'download'])->name('request.download');
    Route::get('/admin/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/admin/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::put('/admin/pegawai/{pegawai}/edit', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/admin/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::post('/admin/data', [DataController::class, 'store'])->name('data.store');
    Route::delete('/admin/data/{data}', [DataController::class, 'destroy'])->name('data.destroy');
});