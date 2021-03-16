<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Masterlist;
use App\Http\Livewire\Forms\PersonalDetail\PersonalDetailShow;
// use App\Http\Livewire\Forms\PersonalDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student/registration', function () {
    return view('student.registration');
})->name('student.registration');

// Route::middleware(['auth:sanctum', 'verified'])->get('/admin/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard')->middleware(['auth:sanctum', 'verified']);

Route::get('/admin/masterlist', Masterlist::class)->name('admin.masterlist')->middleware(['auth:sanctum', 'verified']);

Route::get('/user/personal-details', PersonalDetailShow::class)->name('user.personal-details')->middleware(['auth:sanctum', 'verified']);