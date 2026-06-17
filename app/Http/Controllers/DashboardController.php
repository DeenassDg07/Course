<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isTeacher()) {
            return $this->teacherDashboard();
        } else {
            return $this->studentDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    private function teacherDashboard()
    {
        $courses = Course::where('teacher_id', auth()->id())
                        ->withCount('lessons', 'students')
                        ->latest()
                        ->get();

        return view('dashboard.teacher', compact('courses'));
    }

    private function studentDashboard()
    {
        $enrollments = Enrollment::where('student_id', auth()->id())
                                ->with('course')
                                ->latest()
                                ->get();

        return view('dashboard.student', compact('enrollments'));
    }
}
