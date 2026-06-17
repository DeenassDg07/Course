<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Policies\CoursePolicy;
use App\Policies\LessonPolicy;
use App\Policies\QuizPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class => CoursePolicy::class,
        Lesson::class => LessonPolicy::class,
        Quiz::class => QuizPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Гейты
        Gate::define('be-instructor', function ($user) {
            return in_array($user->role, ['admin', 'instructor']);
        });

        Gate::define('access-admin-panel', function ($user) {
            return $user->role === 'admin';
        });
    }
} }
}
