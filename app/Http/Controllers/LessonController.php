<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();
        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        Gate::authorize('update', $course);
        return view('lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        Gate::authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:0',
        ]);

        $validated['course_id'] = $course->id;
        Lesson::create($validated);

        return redirect()->route('courses.lessons.index', $course)
                        ->with('success', 'Урок добавлен!');
    }

    public function show(Course $course, Lesson $lesson)
    {
        Gate::authorize('view', $lesson);
        $lesson->load('quiz');
        
        return view('lessons.show', compact('course', 'lesson'));
    }

    public function edit(Course $course, Lesson $lesson)
    {
        Gate::authorize('update', $course);
        return view('lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        Gate::authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:0',
        ]);

        $lesson->update($validated);

        return redirect()->route('courses.lessons.show', [$course, $lesson])
                        ->with('success', 'Урок обновлен!');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        Gate::authorize('update', $course);
        $lesson->delete();

        return redirect()->route('courses.lessons.index', $course)
                        ->with('success', 'Урок удален!');
    }
}
