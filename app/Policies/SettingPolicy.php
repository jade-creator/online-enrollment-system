<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Setting $setting) { return
        $setting->allow_irregular_student_to_enroll == 1
            ? Response::allow()
            : Response::deny('This action is unauthorized. Irregular students are not allowed to register, please <a href="#" class="underline">contact us</a> to process your enrollment.');
    }
}
