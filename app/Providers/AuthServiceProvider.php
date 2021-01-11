<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\CourseGrant;
use App\Models\Lesson;
use App\Models\User;
use App\Policies\CoursePolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Course::class => CoursePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('has-subscription', function (User $user, Lesson $lesson) {
            $courseGrant = CourseGrant::where([
                ['user_id', $user->id],
                ['course_id', $lesson->module->course->id],
                ['authorize', CourseGrant::APPROVED],
            ])->first();
            return isset($courseGrant);
        });
    
    }
}
