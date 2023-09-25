
<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyStatusController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\CompanyController as AuthCompanyController;
use App\Http\Controllers\Auth\HomeController;
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

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('user/{profile}/edit',[UserProfileController::class,'edit'])->name('user.profile.edit');
    Route::patch('user/{profile}',[UserProfileController::class,'update'])->name('user.profile.update');
    
    Route::get('user/change-password',[UserPasswordController::class,'edit'])->name('user.password.edit');
    Route::post('user/change-password',[UserPasswordController::class,'update'])->name('user.password.update');


    Route::get('change-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('change-password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('book-ticket/{event}', [BookingController::class, 'store'])->name('book_ticket');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('dashboard', [AuthController::class, 'adminDashboard'])->name('adminDashboard');

        Route::resource('company',CompanyController::class,[
            'names' =>[
                'index' => 'admin.company.index',
                'create' => 'admin.company.create',
                'store' => 'admin.company.store',
                'edit' => 'admin.company.edit',
                'update' => 'admin.company.update',
                'destroy' => 'admin.company.destroy',
            ]
        ])->except('show');   

        Route::get('events', [AdminEventController::class, 'index'])->name('admin.event.index');
        Route::get('event/{event}', [AdminEventController::class, 'edit'])->name('admin.event.edit');
        Route::patch('event/{event}', [AdminEventController::class, 'update'])->name('admin.event.update');
        Route::post('status', CompanyStatusController::class)->name('admin.company.status');
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});



Route::group(['middleware' => 'company', 'prefix' => 'company'], function () {
    Route::resource('event' ,EventController::class,
        [
            'names' => [
                'index'=>'company.event.index',
                'create' => 'company.event.create',
                'edit' => 'company.event.edit',
                'update' => 'company.event.update',
                'destroy' => 'company.event.destroy',
                'store' => 'company.event.store',
            ]
    ])->except('show');    
});

Route::get('company/dashboard', [AuthController::class, 'companyDashboard'])->middleware('company')->name('companyDashboard');
