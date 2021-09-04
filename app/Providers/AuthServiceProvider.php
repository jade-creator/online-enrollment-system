<?php

namespace App\Providers;

use App\Models\AttendedSchool;
use App\Models\Guardian;
use App\Models\Person;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\ProspectusSubject;
use App\Models\Registration;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use App\Policies\AttendedSchoolPolicy;
use App\Policies\GuardianPolicy;
use App\Policies\PersonPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\ProspectusPolicy;
use App\Policies\ProspectusSubjectPolicy;
use App\Policies\RegistrationPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\SectionPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AttendedSchool::class => AttendedSchoolPolicy::class,
        Guardian::class => GuardianPolicy::class,
        Person::class => PersonPolicy::class,
        Prospectus::class => ProspectusPolicy::class,
        Registration::class => RegistrationPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Section::class => SectionPolicy::class,
        Subject::class => SubjectPolicy::class,
        ProspectusSubject::class => ProspectusSubjectPolicy::class,
        Program::class => ProgramPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
