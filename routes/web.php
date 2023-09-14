
<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\CompanyController as AuthCompanyController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Company\EventController;
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


Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'signIn'])->name('signin');
    Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'signIn'])->name('admin.signin');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'signup'])->name('signup');

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

    Route::get('company-register', [AuthCompanyController::class, 'create'])->name('guest.company.create');
    Route::post('company-register', [AuthCompanyController::class, 'store'])->name('guest.company.store');
});

Route::middleware('auth')->group(function () {

    Route::get('profile',[ProfileController::class,'index'])->name('profile');
    Route::get('profile/{profile}/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('profile/{profile}/edit',[ProfileController::class,'update'])->name('profile.update');
    
    Route::get('change-password',[PasswordController::class,'edit'])->name('password.edit');
    Route::patch('change-password',[PasswordController::class,'update'])->name('password.update');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('adminDashboard');
        Route::get('/company', [CompanyController::class, 'index'])->name('companyListing');
        Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('editCompany');
        Route::patch('/company/{company}/edit', [CompanyController::class, 'update'])->name('updateCompany');
        Route::delete('/company/{company}', [CompanyController::class, 'destroy'])->name('destroyCompany');
        Route::get('/add-company', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/add-company', [CompanyController::class, 'store'])->name('company.store');
        Route::get('events', [AdminEventController::class, 'index'])->name('admin.event.index');
        Route::get('event/{event}', [AdminEventController::class, 'edit'])->name('admin.event.edit');
        Route::patch('event/{event}', [AdminEventController::class, 'update'])->name('admin.event.update');
    });


    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::group(['middleware' => ['admin']], function () {
    Route::prefix('admin')->group(function () {
    });
});

Route::group(['middleware' => ['company']], function () {
    Route::get('company/events', [EventController::class, 'index'])->name('event.index');
    Route::get('addEvent', [EventController::class, 'create'])->name('event.create');
    Route::post('addEvent', [EventController::class, 'store'])->name('event.store');
    Route::delete('event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('event/{event}/edit', [EventController::class, 'update'])->name('event.update');
});

Route::get('company/dashboard', [AuthController::class, 'companyDashboard'])->middleware('company')->name('companyDashboard');
