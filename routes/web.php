
<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\HomeController;
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
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'signin'])->name('signin');
    Route::post('register', [AuthController::class, 'signup'])->name('signup');
    Route::get('register', [AuthController::class, 'register'])->name('register');

    Route::get('company-register', [AuthController::class, 'companyRegisterForm'])->name('companyRegisterForm');
    Route::post('company-register', [AuthController::class, 'companyRegister'])->name('companyRegister');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('homepage');
