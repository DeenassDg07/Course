@extends('layouts.app')

@section('title', 'Прохождение теста')

@section('content')
<h1>{{ $quiz->title }}</h1>
<p class="text-muted">Проходной балл: {{ $quiz->passing_score }}%</p>

<form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
    @csrf
    
    @foreach($quiz->questions as $index => $question)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Вопрос {{ $index + 1 }}</h5>
                <p>{{ $question->question_text }}</p>
                
                @foreach($question->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" id="q{{ $question->id }}_{{ $loop->index }}" required>
                        <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Завершить тест</button>
</form>
@endsection
