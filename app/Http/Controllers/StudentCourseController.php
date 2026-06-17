<?php
namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->enrolledCourses()->with('category')->get();
        return view('courses.my-courses', compact('courses'));
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        $course->load('lessons');
        $progress = auth()->user()->enrolledCourses()->where('course_id', $course->id)->first()->pivot->progress;
        
        return view('courses.student-show', compact('course', 'progress'));
    }
}
