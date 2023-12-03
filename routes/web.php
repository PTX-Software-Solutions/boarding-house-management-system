<?php

use App\Livewire\Admin\BoardingHouse as AdminBoardingHouse;
use App\Livewire\Admin\BoardingHouseForm;
use App\Livewire\Admin\BoardingHouseRoom;
use App\Livewire\Admin\BoardingHouseRoomForm;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Auth\Admin\AdminLogin;
use App\Livewire\Auth\Management\ManagementLogin;
use App\Livewire\Auth\User\UserAuth;
use App\Livewire\Auth\User\UserRegister;
use App\Livewire\Houses\HousesForm;
use App\Livewire\Houses\HousesTable;
use App\Livewire\Management\Dashboard;
use App\Livewire\User\BoardingHouse;
use App\Livewire\User\History;
use App\Livewire\User\Home;
use App\Livewire\User\Reservation;
use App\Livewire\User\RoomDetails;
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
});

// ADMIN AUTH
Route::group([
    'middleware' => ['auth.admin'],
    'prefix' => 'admin',
], function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');

    Route::group([
        'prefix' => 'boarding-houses'
    ], function () {
        Route::get('/', AdminBoardingHouse::class)->name('admin.boarding-house');
        Route::get('/create', BoardingHouseForm::class)->name('admin.boarding.house.create');
        Route::get('/edit/{id}', BoardingHouseForm::class)->name('admin.boarding.house.edit');
        Route::get('/{id}/rooms', BoardingHouseRoom::class)->name('admin.boarding-house.rooms');
        Route::get('/{id}/rooms/create', BoardingHouseRoomForm::class)->name('admin.boarding-house.rooms.create');
    });
});

// MANAGEMENT GUEST
Route::group([
    'middleware' => ['guest.management'],
    'prefix'     => 'management',
], function () {
    Route::get('/login', ManagementLogin::class)->name('management.login');
});

// MANAGEMENT AUTH
Route::group([
    'middleware' => ['auth.management'],
    'prefix'     => 'management',
], function () {
    Route::get('/dashboard', Dashboard::class)->name('management.dashboard');
});

// USER GUEST
Route::group([
    'middleware' => ['guest.user'],
], function () {

    Route::get('/login', UserAuth::class)->name('user.login');
    Route::get('/register', UserRegister::class)->name('user.register');
});

// USER AUTH
Route::group([
    'middleware' => ['auth.user'],
], function () {

    Route::get('/', Home::class)->name('user.home');
    Route::get('/boarding-houses/{id}', BoardingHouse::class)->name('user.boarding-house');
    Route::get('/boarding-houses/{id}/room-details/{roomId}', RoomDetails::class)->name('user.room-details');
    Route::get('/reservations', Reservation::class)->name('user.reservation');
    Route::get('/history', History::class)->name('user.history');

    Route::get('/boarding-house', HousesTable::class)->name('boarding.house');
    Route::get('/boarding-house/create', HousesForm::class)->name('boarding.house.form.create');
    Route::get('boarding-house/edit/{id}', HousesForm::class)->name('boarding.house.form.edit');
});
