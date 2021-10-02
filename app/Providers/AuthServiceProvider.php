<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Advice::class => Policies\AdvicePolicy::class,
        Models\AttendedSchool::class => Policies\AttendedSchoolPolicy::class,
        Models\Fee::class => Policies\FeePolicy::class,
        Models\Grade::class => Policies\GradePolicy::class,
        Models\Guardian::class => Policies\GuardianPolicy::class,
        Models\Person::class => Policies\PersonPolicy::class,
        Models\Program::class => Policies\ProgramPolicy::class,
        Models\Prospectus::class => Policies\ProspectusPolicy::class,
        Models\ProspectusSubject::class => Policies\ProspectusSubjectPolicy::class,
        Models\Registration::class => Policies\RegistrationPolicy::class,
        Models\Schedule::class => Policies\SchedulePolicy::class,
        Models\Section::class => Policies\SectionPolicy::class,
        Models\Subject::class => Policies\SubjectPolicy::class,
        Models\User::class => Policies\UserPolicy::class,
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
