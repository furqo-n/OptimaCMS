<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\TeknologiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KarirController;


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

Auth::routes();

Route::group(['prefix' => 'dashboard/admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
    });

    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('akun.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahAkun')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahAkun')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
        });
    Route::controller(PortofolioController::class)
        ->prefix('portofolio')
        ->as('portofolio.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahPortofolio')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahPortofolio')->name('edit');
            Route::delete('{id}/hapus', 'hapusPortofolio')->name('delete');
        });

    Route::controller(KlienController::class)
        ->prefix('klien')
        ->as('klien.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahKlien')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahKlien')->name('edit');
            Route::delete('{id}/hapus', 'hapusKlien')->name('delete');
        });

    Route::controller(TeknologiController::class)
        ->prefix('teknologi')
        ->as('teknologi.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahTeknologi')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahTeknologi')->name('edit');
            Route::delete('{id}/hapus', 'hapusTeknologi')->name('delete');
        });

    Route::controller(KontakController::class)
        ->prefix('kontak')
        ->as('kontak.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahKontak')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahKontak')->name('edit');
            Route::delete('{id}/hapus', 'hapusKontak')->name('delete');
        });

    Route::controller(KarirController::class)
        ->prefix('karir')
        ->as('karir.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahKarir')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahKarir')->name('edit');
            Route::delete('{id}/hapus', 'hapusKarir')->name('delete');
        });

    Route::controller(\App\Http\Controllers\GambarController::class)
        ->prefix('gambar')
        ->as('gambar.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahGambar')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahGambar')->name('edit');
            Route::delete('{id}/hapus', 'hapusGambar')->name('delete');
        });
});
