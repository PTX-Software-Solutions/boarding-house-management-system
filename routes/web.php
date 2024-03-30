<?php

use App\Livewire\Admin\AdminProfile;
use App\Livewire\Admin\BoardingHouse as AdminBoardingHouse;
use App\Livewire\Admin\BoardingHouseForm;
use App\Livewire\Admin\BoardingHouseRoom;
use App\Livewire\Admin\BoardingHouseRoomForm;
use App\Livewire\Admin\Confirmation;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Report;
use App\Livewire\Admin\ReportReservation;
use App\Livewire\Admin\Reservation as AdminReservation;
use App\Livewire\Admin\ReservationForm;
use App\Livewire\Admin\UserForm;
use App\Livewire\Admin\Users;
use App\Livewire\Auth\Admin\AdminLogin;
use App\Livewire\Auth\Admin\ForgotPassword as AdminForgotPassword;
use App\Livewire\Auth\Admin\ResetPassword as AdminResetPassword;
use App\Livewire\Auth\Management\ForgotPassword as ManagementForgotPassword;
use App\Livewire\Auth\Management\ManagementLogin;
use App\Livewire\Auth\Management\ResetPassword as ManagementResetPassword;
use App\Livewire\Auth\User\EmailVerification;
use App\Livewire\Auth\User\ForgotPassword;
use App\Livewire\Auth\User\ResetPassword;
use App\Livewire\Auth\User\UserAuth;
use App\Livewire\Auth\User\UserRegister;
use App\Livewire\Houses\HousesForm;
use App\Livewire\Houses\HousesTable;
use App\Livewire\Management\Dashboard;
use App\Livewire\Management\ManagementBoardingHouse;
use App\Livewire\Management\ManagementBoardingHouseForm;
use App\Livewire\Management\ManagementBoardingHouseRoom;
use App\Livewire\Management\ManagementBoardingHouseRoomForm;
use App\Livewire\Management\ManagementConfirmation;
use App\Livewire\Management\ManagementProfile;
use App\Livewire\Management\ManagementReservation;
use App\Livewire\User\AboutUs;
use App\Livewire\User\BoardingHouse;
use App\Livewire\User\ContactUs;
use App\Livewire\User\Home;
use App\Livewire\User\Profile;
use App\Livewire\User\Reservation;
use App\Livewire\User\RoomDetails;
use App\Livewire\User\TermAndCondition;
use App\Livewire\User\Transaction;
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

// ADMIN GUEST
Route::group([
    'middleware' => ['guest.admin'],
    'prefix' => 'admin'
], function () {
    Route::get('/login', AdminLogin::class)->name('admin.login');
    Route::get('/forgot-password', AdminForgotPassword::class)->name('admin.forgotpassword');
    Route::get('/reset-password/{token}', AdminResetPassword::class)->name('admin.resetpassword');
});

// ADMIN AUTH
Route::group([
    'middleware' => ['auth.admin'],
    'prefix' => 'admin',
], function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/export-pdf', [AdminReservation::class, 'exportPdfReservation'])->name('admin.export.pdf');
    Route::get('/export-pdf-boarding-house', [AdminBoardingHouse::class, 'exportPdfBoardingHouse'])->name('admin.export.pdf.bh');
    Route::get('/export-pdf-users', [Users::class, 'exportPdfBoardingHouse'])->name('admin.export.pdf.users');

    Route::group([
        'prefix' => 'report'
    ], function () {
        Route::get('/', Report::class)->name('admin.report');
        Route::get('/reservation', ReportReservation::class)->name('admin.report.reservation');
    });

    Route::group([
        'prefix' => 'boarding-houses'
    ], function () {
        Route::get('/', AdminBoardingHouse::class)->name('admin.boarding-house');
        Route::get('/create', BoardingHouseForm::class)->name('admin.boarding-house.create');
        Route::get('/edit/{id}', BoardingHouseForm::class)->name('admin.boarding-house.edit');
        Route::get('/{id}/rooms', BoardingHouseRoom::class)->name('admin.boarding-house.rooms');
        Route::get('/{id}/rooms/create', BoardingHouseRoomForm::class)->name('admin.boarding-house.rooms.create');
        Route::get('/{id}/rooms/edit/{roomId}', BoardingHouseRoomForm::class)->name('admin.boarding-house.rooms.edit');
    });

    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('/', Users::class)->name('admin.users');
        Route::get('/create', UserForm::class)->name('admin.users.create');
        Route::get('/edit/{id}', UserForm::class)->name('admin.users.edit');
    });

    Route::group([
        'prefix' => 'reservations'
    ], function () {
        Route::get('/', AdminReservation::class)->name('admin.reservations');
        Route::get('/create', ReservationForm::class)->name('admin.reservation.create');
        Route::get('/edit/{id}', ReservationForm::class)->name('admin.reservation.edit');
    });

    Route::group([
        'prefix' => 'confirmations'
    ], function () {
        Route::get('/', Confirmation::class)->name('admin.confirmations');
    });

    Route::get('/profile', AdminProfile::class)->name('admin.profile');
});

// MANAGEMENT GUEST
Route::group([
    'middleware' => ['guest.management'],
    'prefix'     => 'management',
], function () {
    Route::get('/login', ManagementLogin::class)->name('management.login');
    Route::get('/forgot-password', ManagementForgotPassword::class)->name('management.forgotpassword');
    Route::get('/reset-password/{token}', ManagementResetPassword::class)->name('management.resetpassword');
});

// MANAGEMENT AUTH
Route::group([
    'middleware' => ['auth.management'],
    'prefix'     => 'management',
], function () {
    Route::get('/dashboard', Dashboard::class)->name('management.dashboard');
    Route::get('/export-pdf-boarding-house', [ManagementBoardingHouse::class, 'exportPdfBoardingHouse'])->name('management.export.pdf.bh');
    Route::get('/export-pdf', [ManagementReservation::class, 'exportPdfReservation'])->name('management.export.pdf');

    Route::group([
        'prefix' => 'boarding-houses'
    ], function () {
        Route::get('/', ManagementBoardingHouse::class)->name('management.boarding-house');
        Route::get('/create', ManagementBoardingHouseForm::class)->name('management.boarding-house.create');
        Route::get('/edit/{id}', ManagementBoardingHouseForm::class)->name('management.boarding-house.edit');
        Route::get('/{id}/rooms', ManagementBoardingHouseRoom::class)->name('management.boarding-house.rooms');
        Route::get('/{id}/rooms/create', ManagementBoardingHouseRoomForm::class)->name('management.boarding-house.rooms.create');
        Route::get('/{id}/rooms/edit/{roomId}', ManagementBoardingHouseRoomForm::class)->name('management.boarding-house.rooms.edit');
    });

    Route::group([
        'prefix' => 'reservations'
    ], function () {
        Route::get('/', ManagementReservation::class)->name('management.reservations');
        Route::get('/create', ReservationForm::class)->name('management.reservation.create');
        Route::get('/edit/{id}', ReservationForm::class)->name('management.reservation.edit');
    });

    Route::group([
        'prefix' => 'confirmations'
    ], function () {
        Route::get('/', ManagementConfirmation::class)->name('management.confirmations');
    });

    Route::get('/profile', ManagementProfile::class)->name('management.profile');
});

// USER GUEST
Route::group([
    'middleware' => ['guest.user'],
], function () {

    Route::get('/login', UserAuth::class)->name('user.login');
    Route::get('/register', UserRegister::class)->name('user.register');
    Route::get('/forgot-password', ForgotPassword::class)->name('user.forgotpassword');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('user.resetpassword');
    Route::get('/terms-and-conditions', TermAndCondition::class)->name('user.contactus');
    Route::get('/email/verify', [EmailVerification::class, 'verify'])->name('verification.verify');
});

// USER AUTH
Route::group([
    'middleware' => ['auth.user', 'auth.isBanned'],
], function () {

    Route::get('/about-us', AboutUs::class)->name('user.contactus');
    Route::get('/contact-us', ContactUs::class)->name('user.contactus');
    Route::get('/', Home::class)->name('user.home');
    Route::get('/boarding-houses/{id}', BoardingHouse::class)->name('user.home.boarding-house');
    Route::get('/boarding-houses/{id}/room-details/{roomId}', RoomDetails::class)->name('user.home.room-details');
    Route::get('/reservations', Reservation::class)->name('user.reservation');
    Route::get('/transaction', Transaction::class)->name('user.transaction');

    Route::get('/boarding-house', HousesTable::class)->name('boarding.house');
    Route::get('/boarding-house/create', HousesForm::class)->name('boarding.house.form.create');
    Route::get('boarding-house/edit/{id}', HousesForm::class)->name('boarding.house.form.edit');

    Route::get('/profile', Profile::class)->name('user.profile');
});
