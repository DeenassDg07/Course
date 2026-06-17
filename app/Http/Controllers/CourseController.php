<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'category'])->where('is_published', true);
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $courses = $query->latest()->paginate(9);
        $categories = Category::all();
        
        return view('courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        $course->load(['instructor', 'category', 'lessons']);
        $isEnrolled = auth()->check() && auth()->user()->enrolledCourses()->where('course_id', $course->id)->exists();
        
        return view('courses.show', compact('course', 'isEnrolled'));
    }

    public function enroll(Course $course)
    {
        $this->authorize('enroll', $course);
        auth()->user()->enrolledCourses()->attach($course->id, ['progress' => 0, 'enrolled_at' => now()]);
        
        return redirect()->route('my-courses.show', $course)->with('success', 'Вы успешно записались на курс!');
    }
}
