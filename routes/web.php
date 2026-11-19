<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

Route::get('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'index'])->name('kategori-items.index');
Route::get('/kategori-items/create', [App\Http\Controllers\KategoriItemsController::class, 'create'])->name('kategori-items.create');
Route::post('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'store'])->name('kategori-items.store');
Route::put('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'update'])->name('kategori-items.update');
Route::delete('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'destroy'])->name('kategori-items.destroy');
Route::get('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'show'])->name('kategori-items.show');
