<?php

namespace App\Jobs;

use App\Models\Prospectus;
use App\Models\Section;
use App\Models\Student;
use App\Services\Registration\RegistrationRegularService;
use App\Services\Registration\RegistrationService;
use App\Services\SendNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePreRegistration implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public string $prospectusId;
    public string $studentId;
    public string $curriculumId;
    public string $sectionId;
    public int $totalUnit;
    public bool $isExtension;
    public bool $isRegular;
    public array $selectedSubjectIds;
    public string $notificationSenderId;
    public string $notificationRecipientId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $prospectusId, string $studentId, string $curriculumId, string $sectionId,
        int $totalUnit, bool $isExtension, bool $isRegular, array $selectedSubjectIds, string $notificationSenderId)
    {
        $this->prospectusId = $prospectusId;
        $this->studentId = $studentId;
        $this->curriculumId = $curriculumId;
        $this->sectionId = $sectionId;
        $this->totalUnit = $totalUnit;
        $this->isExtension = $isExtension;
        $this->isRegular = $isRegular;
        $this->selectedSubjectIds = $selectedSubjectIds;
        $this->notificationSenderId = $notificationSenderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        usleep(50000);

        //create registration
        $registrationService = new RegistrationService();

        $registration = $registrationService->createNewRegistration($this->prospectusId, $this->studentId,
            $this->curriculumId, $this->totalUnit, $this->isExtension, $this->isRegular);

        $createdRegistration = $registrationService->store($this->selectedSubjectIds, $registration);

        //update registration's section.
        $section = Section::with('schedules')->find($this->sectionId);

        $updatedRegistration = $registrationService->selectSection($createdRegistration, $section->id, $section->schedules);

        //get recipient info.
        $student = Student::with('user.person')->find($this->studentId);

        //send notification
        (new SendNotification())->dispatch(
            $this->notificationSenderId,
            $student->user_id,
            'Congrats '.$student->user->person->firstname."! you've been pre-registered.",
            '<a class="underline text-blue-500" href="'.route('pre.registration.view', ['regId' => $updatedRegistration->id]).'">View Details.</a>',
        );
    }
}
