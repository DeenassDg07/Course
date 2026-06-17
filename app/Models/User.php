<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function courses() { return $this->hasMany(Course::class, 'instructor_id'); }
    public function enrolledCourses() { return $this->belongsToMany(Course::class, 'course_user')->withPivot('progress', 'enrolled_at', 'completed_at')->withTimestamps(); }
    public function lessonProgress() { return $this->hasMany(LessonProgress::class); }
    public function quizResults() { return $this->hasMany(QuizResult::class); }
    
    public function isAdmin() { return $this->role === 'admin'; }
    public function isInstructor() { return $this->role === 'instructor' || $this->isAdmin(); }
    public function isStudent() { return $this->role === 'student'; }
}
