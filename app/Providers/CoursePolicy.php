<?php
namespace App\Policies;
use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(?User $user): bool { return true; }
    
    public function view(?User $user, Course $course): bool 
    {
        return $course->is_published || ($user && ($user->isAdmin() || $user->id === $course->instructor_id));
    }

    public function create(User $user): bool { return in_array($user->role, ['admin', 'instructor']); }

    public function update(User $user, Course $course): bool 
    {
        return $user->isAdmin() || $user->id === $course->instructor_id;
    }

    public function delete(User $user, Course $course): bool 
    {
        return $user->isAdmin() || $user->id === $course->instructor_id;
    }

    public function enroll(User $user, Course $course): bool 
    {
        return $user->isStudent() && !$course->students()->where('user_id', $user->id)->exists();
    }
}
