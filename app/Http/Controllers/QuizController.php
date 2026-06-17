<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create(Lesson $lesson)
    {
        return view('quizzes.create', compact('lesson'));
    }

    public function store(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score'],
        ]);

        foreach ($validated['questions'] as $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return redirect()->route('courses.lessons.show', [$lesson->course, $lesson])
                        ->with('success', 'Тест создан!');
    }

    public function take(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers', []);
        $questions = $quiz->questions;
        
        $correctCount = 0;
        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = $questions->count() > 0 ? round(($correctCount / $questions->count()) * 100) : 0;
        $passed = $score >= $quiz->passing_score;

        $result = QuizResult::create([
            'student_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'passed' => $passed,
            'answers' => $answers,
        ]);

        return view('quizzes.result', compact('result', 'quiz'));
    }
}
