@extends('layouts.app')

@section('title', 'Результаты теста')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Результаты теста: {{ $quiz->title }}</h3>
            </div>
            <div class="card-body text-center">
                <h2 class="mb-4">
                    @if($result->passed)
                        <span class="text-success">✓ Тест пройден!</span>
                    @else
                        <span class="text-danger">✗ Тест не пройден</span>
                    @endif
                </h2>

                <div class="mb-4">
                    <h4>Ваш результат: {{ $result->score }}%</h4>
                    <div class="progress mb-3" style="height: 30px;">
                        <div class="progress-bar {{ $result->passed ? 'bg-success' : 'bg-danger' }}" 
                             role="progressbar" 
                             style="width: {{ $result->score }}%">
                            {{ $result->score }}%
                        </div>
                    </div>
                    <p>Проходной балл: {{ $quiz->passing_score }}%</p>
                </div>

                <a href="{{ route('courses.show', $quiz->lesson->course) }}" class="btn btn-primary">Вернуться к курсу</a>
            </div>
        </div>
    </div>
</div>
@endsection
