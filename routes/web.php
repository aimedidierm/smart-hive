<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\TrainingController;
use App\Models\Sales;
use App\Models\Training;
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

Route::get('/', function () {
    $sales = Sales::latest()->get();
    return view('home', compact('sales'));
});

Route::post('/orders', [OrderController::class, 'store'])->name('orderRequest');

Route::view('/login', 'login')->name('login');

Route::group(["prefix" => "auth", "as" => "auth."], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
});

Route::group(["prefix" => "admin", "middleware" => "auth", "as" => "admin."], function () {
    Route::get('/', [HardwareController::class, 'index']);
    Route::resource('/trainings', TrainingController::class)->only('index', 'store', 'destroy');
    Route::resource('/clients', ClientController::class)->only('index', 'store', 'destroy');
    Route::get('/training-details/{id}', function ($id) {
        $training = Training::find($id);
        return view('training-details', ['training' => $training]);
    });
    Route::resource('/sales', SalesController::class)->only('index');
});

Route::group(["prefix" => "client", "middleware" => "auth", "as" => "client."], function () {
    Route::get('/', [HardwareController::class, 'index']);
    Route::resource('/sales', SalesController::class)->only('index', 'store', 'destroy');
    Route::resource('/orders', OrderController::class)->only('index');
    Route::get('/training-details/{id}', function ($id) {
        $training = Training::find($id);
        return view('training-details', ['training' => $training]);
    });
});
