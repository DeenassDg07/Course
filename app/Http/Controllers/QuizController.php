<?php

namespace App\Http\Controllers;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function take(Course $course, Quiz $quiz)
    {
        $this->authorize('take', $quiz);
        $quiz->load('questions.answers');
        return view('quizzes.take', compact('course', 'quiz'));
    }

    public function submit(Course $course, Quiz $quiz, Request $request)
    {
        $this->authorize('take', $quiz);
        
        $answers = $request->input('answers', []);
        $totalQuestions = $quiz->questions()->count();
        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id])) {
                $selectedAnswer = $question->answers()->find($answers[$question->id]);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $passed = $score >= $quiz->passing_score;

        QuizResult::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'passed' => $passed,
            'taken_at' => now(),
        ]);

        return redirect()->route('my-courses.show', $course)
            ->with('success', $passed ? "Тест сдан! Ваш результат: {$score}%" : "Тест не сдан. Ваш результат: {$score}%. Попробуйте еще раз.");
    }
}
