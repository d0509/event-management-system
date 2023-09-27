<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyStatusController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\CompanyController as AuthCompanyController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Company\BookingController as CompanyBookingController;
use App\Http\Controllers\Company\EventController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\PasswordController as UserPasswordController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
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

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.create');
    Route::post('forgot-password', [AuthController::class, 'resetPassword'])->name('forgot-password.store');
    Route::get('reset-password/{token}', [AuthController::class, 'ResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [AuthController::class, 'submitReset'])->name('reset.password.post');

    Route::get('/', [HomeController::class, 'index'])->name('homepage');
    Route::get('event/{event}', [UserEventController::class, 'show'])->name('user.event.show');
    Route::get('company-register', [AuthCompanyController::class, 'create'])->name('guest.company.create');
    Route::post('company-register', [AuthCompanyController::class, 'store'])->name('guest.company.store');
});

Route::middleware('auth')->group(function () {

    Route::resource('profile', ProfileController::class)->except('create', 'store', 'delete', 'show');


    Route::prefix('user')->name('user.')->group(function(){
        Route::resource('profile',UserProfileController::class)->only('edit','update');
        
        Route::resource('change-password',UserPasswordController::class)->only('edit','update');
    });
    
    Route::get('user/booking_history', [BookingController::class, 'index'])->name('user.booking.history');
    Route::post('book-ticket/{event}', [BookingController::class, 'store'])->name('book_ticket');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Route::get('dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('dashboard',[DashboardController::class, 'getData'])->name('dashboard');
        
        
        Route::resource('change-password',PasswordController::class)->only('edit','update');

        Route::resource('company', CompanyController::class)->except('show');

        Route::resource('event',AdminEventController::class)->only('index','edit','update');

        Route::post('status', CompanyStatusController::class)->name('company.status');
        
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});



Route::middleware('company')->prefix('company')->name('company.')->group(function () {

    Route::resource('event',EventController::class)->except('show');

    Route::get('booking',[CompanyBookingController::class,'index'])->name('booking.index');
    Route::get('dashboard', [AuthController::class, 'companyDashboard'])->middleware('company')->name('dashboard');
});

