<?php

use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Masterlist;
use App\Http\Livewire\Forms\PersonalDetail\AdminDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\PersonalDetailShow;
use App\Http\Livewire\Forms\PersonalDetail\StudentDetailForm;
use App\Http\Livewire\Student\Registration;
use Illuminate\Support\Facades\Route;

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

//------START GUEST----
Route::get('/', function () {
    return view('welcome');
});
//------END GUEST-------


//------START STUDENT----
Route::get('/student/registration', Registration::class)->name('student.registration')->middleware(['auth:sanctum', 'verified', 'user.detail']);
//------END STUDENT----


//------START ADMIN----
Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard')->middleware(['auth:sanctum', 'verified', 'user.detail']);

Route::get('/admin/masterlist', Masterlist::class)->name('admin.masterlist')->middleware(['auth:sanctum', 'verified', 'user.detail']);
//------END ADMIN----


//------START AUTH----
Route::get('/user/personal-details', PersonalDetailShow::class)->name('user.personal-details')->middleware(['auth:sanctum', 'verified', 'user.detail']);

Route::get('/user/personal-details/admin', AdminDetailForm::class)->name('user.personal-details.admin')->middleware(['auth:sanctum', 'verified', 'role:admin','detail']);

Route::get('/user/personal-details/student', StudentDetailForm::class)->name('user.personal-details.student')->middleware(['auth:sanctum', 'verified', 'role:student', 'detail']);
//------END ADMIN----
