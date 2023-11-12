<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Auth\User\UserAuth;
use App\Livewire\Auth\User\UserRegister;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Houses\HousesForm;
use App\Livewire\Houses\HousesTable;
use App\Livewire\User\BoardingHouse;
use App\Livewire\User\History;
use App\Livewire\User\Home;
use App\Livewire\User\Reservation;
use App\Livewire\User\RoomDetails;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// // ADMIN GUEST
// Route::group([
//     'middleware' => ['guest.admin'],
//     'prefix' => 'admin'
// ], function () {
//     // Route::get('/login', AdminAuth::class)->name('admin.login');
// });

// // ADMIN AUTH
// Route::group([
//     'middleware' => ['auth.admin'],
//     'prefix' => 'admin',
// ], function () {
//     // Route::get('/home', Dashboard::class)->name('home');
//     // Route::get('/boarding-house', HousesTable::class)->name('boarding.house');
//     // Route::get('/boarding-house/create', HousesForm::class)->name('boarding.house.form.create');
//     // Route::get('boarding-house/edit/{id}', HousesForm::class)->name('boarding.house.form.edit');
//     // Route::get('/reservation', Reservation::class)->name('reservation');
// });


// // MANAGEMENT GUEST
// Route::group([
//     'middleware' => ['guest.management'],
//     'prefix'     => 'management',
// ], function () {
//     // Route::get('/login', ManagementAuth::class)->name('management.login');
//     // Route::get('/register', ManagementAuth::class)->name('management.register');
// });

// Route::get('/home', Dashboard::class)->name('home');
// Route::get('/boarding-house', HousesTable::class)->name('boarding.house');
// Route::get('/boarding-house/create', HousesForm::class)->name('boarding.house.form.create');
// Route::get('boarding-house/edit/{id}', HousesForm::class)->name('boarding.house.form.edit');
// Route::get('/reservation', Reservation::class)->name('reservation');

// Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
// Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Route::get('/about', function () {
//     return view('about');
// })->name('about');

// // MANAGEMENT AUTH
// Route::group([
//     'middleware' => ['auth.management'],
//     'prefix'     => 'management',
// ], function () {
//     // Route::get('/home', Dashboard::class)->name('home');
//     // Route::get('/boarding-house', HousesTable::class)->name('boarding.house');
//     // Route::get('/boarding-house/create', HousesForm::class)->name('boarding.house.form.create');
//     // Route::get('boarding-house/edit/{id}', HousesForm::class)->name('boarding.house.form.edit');
//     // Route::get('/reservation', Reservation::class)->name('reservation');
// });



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
