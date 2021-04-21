<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Masterlist;
use App\Http\Livewire\Student\Registration;
use App\Http\Livewire\Forms\Contact\ContactShow;
use App\Http\Livewire\Forms\Guardian\GuardianShow;
use App\Http\Livewire\Forms\Education\EducationShow;
use App\Http\Livewire\Forms\Profile\SecuritySettingShow;
use App\Http\Livewire\Admin\UserComponent\UserAddComponent;
use App\Http\Livewire\Forms\PersonalDetail\AdminDetailForm;
use App\Http\Livewire\Admin\UserComponent\UserViewComponent;
use App\Http\Livewire\Forms\PersonalDetail\StudentDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\PersonalDetailShow;
use App\Http\Livewire\Admin\SchoolManagement\SchoolTypeComponent;

/*
|--------------------------------------------------------------------------
| Jetstream Routes
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/jetstream.php';

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


Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    // start guard
    Route::group(['middleware' => 'user.detail', 'prefix' => 'user', 'as' => 'user.'], function (){
        Route::get('/personal-details', PersonalDetailShow::class)->name('personal-details');
        Route::get('/contacts', ContactShow::class)->name('contacts');
        Route::get('/guardian-details', GuardianShow::class)->name('guardian-details');
        Route::get('/education', EducationShow::class)->name('education');
        Route::get('/security-settings', SecuritySettingShow::class)->name('security-settings');
    });
    // end guard

    // start student
    Route::middleware(['role:student'])->group(function (){
        Route::get('/user/personal-details/student', StudentDetailForm::class)->middleware(['detail'])->name('user.personal-details.student');

        Route::group(['middleware' => 'user.detail', 'prefix' => 'student', 'as' => 'student.'], function (){
            Route::get('/registration', Registration::class)->name('registration'); //renamecomponent
        });
    });
    // end student

    // start admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/user/personal-details/admin', AdminDetailForm::class)->middleware(['detail'])->name('user.personal-details.admin');
    
        Route::group(['middleware' => 'user.detail', 'prefix' => 'admin', 'as' => 'admin.'], function (){
            Route::get('/dashboard', Dashboard::class)->name('dashboard'); //renamecomponent
            Route::get('/masterlist', Masterlist::class)->name('masterlist'); //renamecomponent

            Route::group(['prefix' => 'school-management', 'as' => 'school.'], function (){
                Route::get('/types', SchoolTypeComponent::class)->name('type.view');
            });

            Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
                Route::get('', UserViewComponent::class)->name('view');
                Route::get('/create', UserAddComponent::class)->name('create');
            });          
        });
    });
    // end admin
});