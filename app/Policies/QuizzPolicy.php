<?php

namespace App\Policies;

use App\Models\Quizz;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizzPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function hasOwnership(User $user, Quizz $quizz){
        return $user->id === $quizz->module->course->user_id;
    }
}
