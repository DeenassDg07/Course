<?php
namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstructorCourseController extends Controller
{
    public function __construct() { $this->middleware('can:be-instructor'); }

    public function index()
    {
        $courses = auth()->user()->courses()->with('category')->latest()->paginate(10);
        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('instructor.courses.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $validated['instructor_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        Course::create($validated);
        return redirect()->route('instructor.courses.index')->with('success', 'Курс успешно создан');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('instructor.courses.edit', compact('course', 'categories' => Category::all()));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        $course->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'cover_image' => 'nullable|image|max:2048',
        ]) + ($request->hasFile('cover_image') ? ['cover_image' => $request->file('cover_image')->store('covers', 'public')] : []));
        
        return redirect()->route('instructor.courses.index')->with('success', 'Курс обновлен');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Курс удален');
    }

    public function students(Course $course)
    {
        $this->authorize('update', $course);
        $students = $course->students()->withPivot('progress')->get();
        return view('instructor.courses.students', compact('course', 'students'));
    }
}
