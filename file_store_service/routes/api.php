<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\DeskController;
use \App\Http\Controllers\FilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/file', [DeskController::class, 'index']) ;
Route::get('/file', [DeskController::class, 'index']) ;
Route::get('/download/{id}', [DeskController::class, 'download']);
Route::get('/delete/{id}', [DeskController::class, 'delete']);
Route::post('/upload', [DeskController::class, 'upload']);

