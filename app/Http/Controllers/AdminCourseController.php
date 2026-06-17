<?php
namespace App\Http\Controllers;
use App\Models\Course;

class AdminCourseController extends Controller
{
    public function __construct() { $this->middleware('can:access-admin-panel'); }

    public function index()
    {
        $courses = Course::with('instructor', 'category')->latest()->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function togglePublish(Course $course)
    {
        $course->update(['is_published' => !$course->is_published]);
        $status = $course->is_published ? 'опубликован' : 'скрыт';
        return back()->with('success', "Курс '{$course->title}' теперь {$status}.");
    }
}
