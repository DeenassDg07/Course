<?php
namespace App\Policies;
use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    public function view(User $user, Quiz $quiz): bool 
    {
        if ($user->isAdmin()) return true;
        if ($user->id === $quiz->lesson->course->instructor_id) return true;
        return $user->enrolledCourses()->where('course_id', $quiz->lesson->course_id)->exists();
    }

    public function take(User $user, Quiz $quiz): bool 
    {
        return $user->isStudent() && $user->enrolledCourses()->where('course_id', $quiz->lesson->course_id)->exists();
    }

    public function create(User $user, Quiz $quiz): bool 
    {
        return $user->isAdmin() || $user->id === $quiz->lesson->course->instructor_id;
    }

    public function update(User $user, Quiz $quiz): bool 
    {
        return $user->isAdmin() || $user->id === $quiz->lesson->course->instructor_id;
    }

    public function delete(User $user, Quiz $quiz): bool 
    {
        return $user->isAdmin() || $user->id === $quiz->lesson->course->instructor_id;
    }
}
