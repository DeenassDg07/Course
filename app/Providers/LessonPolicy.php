<?php
namespace App\Policies;
use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson): bool 
    {
        if ($user->isAdmin()) return true;
        if ($user->id === $lesson->course->instructor_id) return true;
        return $user->enrolledCourses()->where('course_id', $lesson->course_id)->exists();
    }

    public function create(User $user, Lesson $lesson): bool 
    {
        return $user->isAdmin() || $user->id === $lesson->course->instructor_id;
    }

    public function update(User $user, Lesson $lesson): bool 
    {
        return $user->isAdmin() || $user->id === $lesson->course->instructor_id;
    }

    public function delete(User $user, Lesson $lesson): bool 
    {
        return $user->isAdmin() || $user->id === $lesson->course->instructor_id;
    }
}
