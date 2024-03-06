<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;

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

Route::get('/', [FilesController::class, 'index'])->name('files.index');
Route::get('/create', [FilesController::class, 'create'])->name('files.create');
Route::post('/store', [FilesController::class, 'store'])->name('files.store');
Route::get('/edit/{id}', [FilesController::class, 'edit'])->name('files.edit');
Route::put('/update/{id}', [FilesController::class, 'update'])->name('files.update');
Route::get('/delete/{id}', [FilesController::class, 'delete'])->name('files.delete');
Route::get('/download/{id}', [FilesController::class, 'download'])->name('files.download');

Route::get('/api/test', [FilesController::class, 'test'])->name('files.index');
