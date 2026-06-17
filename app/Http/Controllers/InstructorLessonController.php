<?php
namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class InstructorLessonController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|integer',
            'content_type' => 'required|in:text,video',
            'content' => 'required|string',
        ]);
        $course->lessons()->create($validated);
        return back()->with('success', 'Урок добавлен!');
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorize('update', $lesson);
        $lesson->update($request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|integer',
            'content_type' => 'required|in:text,video',
            'content' => 'required|string',
        ]));
        return back()->with('success', 'Урок обновлен');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $this->authorize('delete', $lesson);
        $lesson->delete();
        return back()->with('success', 'Урок удален');
    }
}
