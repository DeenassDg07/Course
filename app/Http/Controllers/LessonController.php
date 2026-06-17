<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        $this->authorize('view', $lesson);
        $isCompleted = auth()->user()->lessonProgress()
            ->where('lesson_id', $lesson->id)
            ->where('is_completed', true)
            ->exists();
            
        return view('lessons.show', compact('course', 'lesson', 'isCompleted'));
    }

    public function complete(Course $course, Lesson $lesson)
    {
        $this->authorize('view', $lesson);
        
        $progress = auth()->user()->lessonProgress()->updateOrCreate(
            ['lesson_id' => $lesson->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        // Обновляем общий прогресс курса
        $totalLessons = $course->lessons()->count();
        $completedLessons = auth()->user()->lessonProgress()
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->where('is_completed', true)
            ->count();
            
        $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        auth()->user()->enrolledCourses()->updateExistingPivot($course->id, ['progress' => $courseProgress]);

        return back()->with('success', 'Урок отмечен как пройденный!');
    }
}
