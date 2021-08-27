<?php

use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\FeeComponent;
use App\Http\Livewire\Admin\GradeComponent;
use App\Http\Livewire\Admin\UserComponent\UserAddComponent;
use App\Http\Livewire\Admin\UserComponent\UserViewComponent;
use App\Http\Livewire\Admin\ProgramComponent\ProgramViewComponent;
use App\Http\Livewire\Admin\PreEnrollmentComponent;
use App\Http\Livewire\Admin\SectionComponent;
use App\Http\Livewire\Admin\SubjectComponent;
use App\Http\Livewire\Forms\Contact\ContactShow;
use App\Http\Livewire\Forms\Guardian\GuardianShow;
use App\Http\Livewire\Forms\Education\EducationShow;
use App\Http\Livewire\Forms\PersonalDetail\AdminDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\StudentDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\PersonalDetailShow;
use App\Http\Livewire\Forms\Profile\SecuritySettingShow;
use App\Http\Livewire\Forms\Program\ProgramCreateForm;
use App\Http\Livewire\Forms\Program\ProgramUpdateForm;
use App\Http\Livewire\Forms\User;
use App\Http\Livewire\Admin\ProspectusComponent;
use App\Http\Livewire\Student;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
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

    // start admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/user/personal-details/admin', AdminDetailForm::class)->middleware(['detail'])->name('user.personal-details.admin');

        Route::group(['middleware' => 'user.detail', 'prefix' => 'admin', 'as' => 'admin.'], function (){
            Route::get('/dashboard', Dashboard::class)->name('dashboard'); // TODO : renamecomponent

            Route::get('/grades', GradeComponent\GradeViewComponent::class)->name('grades.view');

            Route::group(['prefix' => 'pre-enrollments'], function (){
                Route::get('', PreEnrollmentComponent\PreEnrollmentViewComponent::class)->name('pre.enrollments.view');
                Route::get('/released', PreEnrollmentComponent\ReleasedPreEnrollmentComponent::class)->name('released.enrollments.view');
            });

            Route::get('/fees', FeeComponent\FeeViewComponent::class)->name('fees.view');

            Route::get('/subjects', SubjectComponent\SubjectIndexComponent::class)->name('subjects.view');

            Route::group(['prefix' => 'programs', 'as' => 'programs.'], function (){
                Route::get('', ProgramViewComponent::class)->name('view');
                Route::get('/create', ProgramCreateForm::class)->name('create');
                Route::get('/update/{program}', ProgramUpdateForm::class)->name('update');
            });

            Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
                Route::get('', UserViewComponent::class)->name('view');
                Route::get('/create', UserAddComponent::class)->name('create');
            });
        });
    });
    // end admin

    // admin and student
    Route::middleware(['role:admin|student', 'user.detail'])->group(function (){
        Route::get('/sections', SectionComponent\SectionIndexComponent::class)->name('sections.view');

        Route::get('/prospectuses', ProspectusComponent\ProspectusViewComponent::class)->name('prospectuses.view');

        Route::group(['prefix' => 'pre-registration', 'as' => 'pre.registration.'], function () {
            Route::get('/{regId}', Student\PreRegistrationComponent::class)->name('view');
            Route::get('/{regId}/pdf', [PreEnrollmentComponent\PreEnrollmentPdfComponent::class, 'createPDF'])->name('pdf');
        });

        Route::get('/user/personal-profile/{userId}', User\UserProfileComponent::class)->name('user.personal.profile.view');
    });
    // end

    // start student
    Route::middleware(['role:student'])->group(function (){
        Route::get('/user/personal-details/student', StudentDetailForm::class)->middleware(['detail'])->name('user.personal-details.student');

        Route::group(['middleware' => 'user.detail', 'prefix' => 'student', 'as' => 'student.'], function (){
            Route::get('/registrations', Student\RegistrationViewComponent::class)->name('registration');
            Route::get('/registrations/create', Student\Registration::class)->middleware(['password.confirm'])->name('registrations.create');
            Route::get('/grades', Student\StudentGradeViewComponent::class)->name('grades.view');
        });
    });
    // end student
});
