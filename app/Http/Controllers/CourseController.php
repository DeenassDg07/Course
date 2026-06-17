<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->latest()->paginate(12);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        Gate::authorize('create', Course::class);
        return view('courses.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Course::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $validated['teacher_id'] = auth()->id();

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Курс успешно создан!');
    }

    public function show(Course $course)
    {
        $course->load(['teacher', 'lessons', 'students']);
        $isEnrolled = auth()->check() && $course->students->contains(auth()->id());
        
        return view('courses.show', compact('course', 'isEnrolled'));
    }

    public function edit(Course $course)
    {
        Gate::authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        Gate::authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('success', 'Курс обновлен!');
    }

    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Курс удален!');
    }
}
