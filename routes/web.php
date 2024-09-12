<?php

use App\Http\Controllers\AuthController;
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

Route::view('/', 'home');
Route::view('/login', 'login')->name('login');

Route::group(["prefix" => "auth", "as" => "auth."], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
});

Route::group(["prefix" => "admin", "middleware" => "auth", "as" => "admin."], function () {
    Route::get('/', function () {
        return view('dashboard');
    });
});
