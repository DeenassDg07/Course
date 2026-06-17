<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        if ($course->students()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Вы уже записаны на этот курс');
        }

        Enrollment::create([
            'student_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
        ]);

        return redirect()->route('courses.show', $course)
                        ->with('success', 'Вы успешно записались на курс');
    }

    public function myCourses()
    {
        $enrollments = Enrollment::where('student_id', auth()->id())
                                ->with('course')
                                ->latest()
                                ->get();

        return view('enrollments.my-courses', compact('enrollments'));
    }

    public function updateProgress(Request $request, Course $course)
    {
        $enrollment = Enrollment::where('student_id', auth()->id())
                               ->where('course_id', $course->id)
                               ->firstOrFail();

        $totalLessons = $course->lessons()->count();
        $completedLessons = $request->input('completed_lessons', 0);
        
        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        $enrollment->update([
            'progress' => $progress,
            'completed_at' => $progress === 100 ? now() : null,
        ]);

        return response()->json(['success' => true, 'progress' => $progress]);
    }
}
