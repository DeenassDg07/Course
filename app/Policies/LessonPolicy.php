<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson)
    {
        // Студент может просматривать урок только если записан на курсd
        if ($user->isStudent()) {
            return $lesson->course->students->contains($user->id);
        }
        
        // Преподаватель может просматривать свои уроки
        if ($user->isTeacher()) {
            return $lesson->course->teacher_id === $user->id;
        }
        
        // Админ может просматривать все
        return $user->isAdmin();
    }
}
