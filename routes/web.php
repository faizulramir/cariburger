<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/create', [App\Http\Controllers\DataController::class, 'index'])->name('create.index');

Route::post('/create/post', [App\Http\Controllers\DataController::class, 'create'])->name('create.post');
Route::get('/getStalls/{data}/{type}', [App\Http\Controllers\HomeController::class, 'getStalls'])->name('home.getstalls');
Route::get('/getStall/{id}', [App\Http\Controllers\HomeController::class, 'getStall'])->name('home.getstall');
Route::post('/editStall', [App\Http\Controllers\HomeController::class, 'editStall'])->name('home.editStall');
