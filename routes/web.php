<?php

use App\Http\Controllers\PaypalPaymentController;
use App\Http\Livewire\Admin\AdvisingComponent;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\CurriculumComponent;
use App\Http\Livewire\Admin\FacultyComponent;
use App\Http\Livewire\Admin\FeeComponent;
use App\Http\Livewire\Admin\GradeComponent;
use App\Http\Livewire\Admin\UserComponent;
use App\Http\Livewire\Admin\PaymentComponent;
use App\Http\Livewire\Admin\PreEnrollmentComponent;
use App\Http\Livewire\Admin\ProgramComponent;
use App\Http\Livewire\Admin\SectionComponent;
use App\Http\Livewire\Admin\SubjectComponent;
use App\Http\Livewire\Forms\Contact\ContactShow;
use App\Http\Livewire\Forms\Guardian\GuardianShow;
use App\Http\Livewire\Forms\Education\EducationShow;
use App\Http\Livewire\Forms\PersonalDetail\AdminDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\StudentDetailForm;
use App\Http\Livewire\Forms\PersonalDetail\PersonalDetailShow;
use App\Http\Livewire\Forms\Profile\SecuritySettingShow;
use App\Http\Livewire\Forms\User;
use App\Http\Livewire\Admin\ProspectusComponent;
use App\Http\Livewire\Student;
use App\Http\Livewire\Student\RegistrationComponent;
use App\Http\Controllers\PDFController;
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

// View pdf
Route::get('/view-pdf', function () {
    return view('pdf.dashboard-overview');
});

// Downlaod pdf test
//done Route::get('/registration-pdf/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('registration.pdf');
//done Route::get('/grade-pdf/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('grade.pdf');
//done Route::get('/classlist-pdf/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('classlist.pdf');
//Route::get('/masterlist-pdf/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('masterlist.pdf');
//done Route::get('/schedule-pdf/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('schedule.pdf');
//done Route::get('/dashboard-overview/{pdflocation}/{pdfname}', [PDFController::class, 'downloadPDF'])->name('dashboard-overview.pdf');
//------END GUEST-------


Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    // account settings
    Route::group(['middleware' => 'user.detail', 'prefix' => 'user', 'as' => 'user.'], function (){
        Route::get('/personal-details', PersonalDetailShow::class)->name('personal-details');
        Route::get('/contacts', ContactShow::class)->name('contacts');
        Route::get('/guardian-details', GuardianShow::class)->name('guardian-details');
        Route::get('/education', EducationShow::class)->name('education');
        Route::get('/security-settings', SecuritySettingShow::class)->name('security-settings');
    });

    // start admin
    Route::middleware(['role:admin'])->group(function () {
//        Route::get('/user/personal-details/employee', AdminDetailForm::class)->middleware(['detail'])->name('user.personal-details.admin');

        Route::group(['middleware' => ['user.detail', 'approved'], 'prefix' => 'admin', 'as' => 'admin.'], function (){

            Route::group(['prefix' => 'curricula', 'as' => 'curricula.'], function (){
                Route::get('', CurriculumComponent\CurriculumIndexComponent::class)->name('view');
                Route::get('/create', CurriculumComponent\CurriculumAddComponent::class)->name('create');
                Route::get('/{curriculum}/update', CurriculumComponent\CurriculumUpdateComponent::class)->name('update');
            });

            //admin faculty routes
            Route::group(['prefix' => 'faculties', 'as' => 'faculties.'], function (){
                Route::get('/create', FacultyComponent\FacultyAddComponent::class)->name('create');
            });

            Route::group(['prefix' => 'advising', 'as' => 'advising.'], function (){
                Route::get('', AdvisingComponent\AdvisingIndexComponent::class)->name('view');
                Route::get('/create', AdvisingComponent\AdvisingAddComponent::class)->name('create');
                Route::get('/{advice}/update', AdvisingComponent\AdvisingUpdateComponent::class)->name('update');
            });

            Route::get('/dashboard', Dashboard::class)->name('dashboard');

            //admin program routes
            Route::group(['prefix' => 'programs', 'as' => 'programs.'], function (){
                Route::get('', ProgramComponent\ProgramIndexComponent::class)->name('view');
                Route::get('/create', ProgramComponent\ProgramAddComponent::class)->name('create');
                Route::get('/{program}/update', ProgramComponent\ProgramUpdateComponent::class)->name('update');
            });

            //admin fee routes
            Route::group(['prefix' => 'fees', 'as' => 'fees.'], function (){
                Route::get('', FeeComponent\FeeIndexComponent::class)->name('view');
                Route::get('/create', FeeComponent\FeeAddComponent::class)->name('create');
                Route::get('{fee}/update', FeeComponent\FeeUpdateComponent::class)->name('update');
            });

            //admin user routes
            Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
                Route::get('', UserComponent\UserIndexComponent::class)->name('view');
                Route::get('/create', UserComponent\UserAddComponent::class)->name('create');
            });

            //admin settings route
            Route::get('/settings', \App\Http\Livewire\Admin\SettingsComponent::class)->name('settings');

            //admin backup route
            Route::view('/backup', 'laravel_backup_panel::layout')->middleware('password.confirm')->name('backup');

            Route::get('/dashboard-overview-pdf', [PDFController::class, 'streamDashboard'])->name('stream.dashboard.pdf');
        });
    });
    // end admin

    //start: registrar
    Route::middleware(['role:registrar'])->group(function () {
        Route::get('/user/personal-details/registrar', AdminDetailForm::class)->middleware(['detail'])->name('user.personal-details.registrar');
    });
    //end: registrar

    //start: admin and registrar
    Route::middleware(['role:admin|registrar', 'user.detail', 'approved'])->group(function () {
        Route::group(['as' => 'admin.'], function () {
            Route::get('/pre-enrollments/student/{student}/create/{registration?}', PreEnrollmentComponent\StudentRegistrationAddComponent::class)->name('students.registration.create');

            Route::get('/pre-enrollments/student/{student}/regular/{prospectusSlug}/create/{registration?}', PreEnrollmentComponent\StudentRegularAddComponent::class)->name('students.regular.create');

            Route::get('/pre-enrollments/student/{student}/irregular/{prospectusSlug}/create/{registration?}', PreEnrollmentComponent\StudentIrregularAddComponent::class)->name('students.irregular.create');

            Route::get('/student/{student}/update', UserComponent\StudentUpdateComponent::class)->name('student.update');

            Route::get('/grade-report/{registration}', GradeComponent\GradePdfComponent::class)->name('grade.report');
        });

        Route::get('users/students', UserComponent\StudentIndexComponent::class)->name('users.students.index');

        //stream pdf
        Route::get('/registration-pdf/{registration}', [PDFController::class, 'streamRegistration'])->name('stream.registration.pdf');
        Route::get('/grade-pdf/{registration}', [PDFController::class, 'streamGrade'])->name('stream.grade.pdf');
        Route::get('/masterlist-pdf', [PDFController::class, 'streamMasterlist'])->name('stream.masterlist.pdf');
    });
    //end: admin and registrar

    //start: admin and dean.
    Route::group(['middleware' => ['role:admin|dean', 'user.detail', 'approved'], 'as' => 'admin.'], function () {

        //admin prospectus routes
        Route::get('/prospectuses', ProspectusComponent\ProspectusIndexComponent::class)->name('prospectuses.view');

        //admin section routes
        Route::group(['prefix' => 'sections', 'as' => 'sections.'], function (){
            Route::get('/create', SectionComponent\SectionAddComponent::class)->name('create');
            Route::get('{section}/update', SectionComponent\SectionUpdateComponent::class)->name('update');
        });

        //admin faculty routes
        Route::group(['prefix' => 'faculties', 'as' => 'faculties.'], function (){
            Route::get('', FacultyComponent\FacultyIndexComponent::class)->name('view');
            Route::get('{faculty}/update', FacultyComponent\FacultyUpdateComponent::class)->name('update');
        });

        //subject routes
        Route::group(['prefix' => 'subjects', 'as' => 'subjects.'], function () {
            Route::get('', SubjectComponent\SubjectIndexComponent::class)->name('view');
            Route::get('/create', SubjectComponent\SubjectAddComponent::class)->name('create');
            Route::get('{subject}/update', SubjectComponent\SubjectUpdateComponent::class)->name('update');
        });
    });
    //end: admin and dean.

    //start: all except student
    Route::middleware(['role:admin|registrar|dean|faculty member', 'user.detail', 'approved'])->group(function () {
        Route::get('/user/personal-details/employee', AdminDetailForm::class)->middleware(['detail'])->name('user.personal-details.admin');

        Route::group(['as' => 'admin.'], function () {
            Route::get('/pre-enrollments', PreEnrollmentComponent\PreEnrollmentViewComponent::class)->name('pre.enrollments.view');

            Route::get('/grades', GradeComponent\GradeIndexComponent::class)->name('grades.view');

            //admin payment routes
            Route::group(['prefix' => 'payments', 'as' => 'payments.'], function (){
                Route::get('', PaymentComponent\PaymentIndexComponent::class)->name('view');
            });
        });

        Route::get('/sections', SectionComponent\SectionIndexComponent::class)->name('sections.view');

        Route::get('/class-list/{section}', [PDFController::class, 'streamClasslist'])->name('stream.class-list.pdf');
        Route::get('/schedule-timetable/{section}', [PDFController::class, 'streamSchedule'])->name('stream.schedule.pdf');
    });
    //end: all except student

    // start: all
    Route::middleware(['role:admin|registrar|student|dean|faculty member', 'user.detail'])->group(function (){
        Route::middleware('approved')->group(function () {
            Route::get('/pre-registration/{regId}/details', RegistrationComponent\RegistrationViewComponent::class)->name('pre.registration.view');
        });

        Route::get('/user/personal-profile/{userId}', User\UserProfileComponent::class)->name('user.personal.profile.view');

        Route::get('/paypal-transaction/pdf/{transaction}', [PDFController::class, 'streamTransaction'])->name('stream.transaction.pdf');
    });
    // end: all

    // start student
    Route::middleware(['role:student'])->group(function (){
        Route::get('/user/personal-details/student', StudentDetailForm::class)->middleware(['detail'])->name('user.personal-details.student');

        Route::group(['middleware' => ['user.detail', 'approved'], 'prefix' => 'student', 'as' => 'student.'], function (){

            Route::group(['prefix' => 'pre-registrations', 'as' => 'registrations.'], function () {
                Route::get('', RegistrationComponent\RegistrationIndexComponent::class)->name('index');
                Route::get('/create', RegistrationComponent\RegistrationAddComponent::class)->name('create');
                Route::get('/{prospectusSlug}/regular', RegistrationComponent\RegularAddComponent::class)->name('regular.create');
                Route::get('/{prospectusSlug}/irregular', RegistrationComponent\IrregularAddComponent::class)->name('irregular.create');
            });

            Route::get('/grades', Student\StudentGradeViewComponent::class)->name('grades.view');

            //paypal routes
            Route::get('paywithpaypal/{registrationId?}', [PaypalPaymentController::class, 'payWithPaypal'])->name('paywithpaypal');
            Route::post('paypal', [PaypalPaymentController::class, 'postPaymentWithpaypal'])->name('paypal');
            Route::get('paypal', [PaypalPaymentController::class, 'getPaymentStatus'])->name('status');
            Route::get('/payments', Student\Payment\PaymentIndexComponent::class)->name('payments.view');
        });
    });
    // end student
});
