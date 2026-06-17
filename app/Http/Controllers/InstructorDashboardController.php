<?php
namespace App\Http\Controllers;
use App\Models\Course;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $coursesCount = auth()->user()->courses()->count();
        $studentsCount = auth()->user()->courses()->withCount('students')->get()->sum('students_count');
        $courses = auth()->user()->courses()->with('category')->latest()->take(5)->get();
        
        return view('instructor.dashboard.index', compact('coursesCount', 'studentsCount', 'courses'));
    }
}
