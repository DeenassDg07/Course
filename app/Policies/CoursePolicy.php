<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function create(User $user)
    {
        return $user->isTeacher() || $user->isAdmin();
    }

    public function update(User $user, Course $course)
    {
        return $user->id === $course->teacher_id || $user->isAdmin();
    }

    public function delete(User $user, Course $course)
    {
        return $user->id === $course->teacher_id || $user->isAdmin();
    }
}
