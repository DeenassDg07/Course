@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ $lesson->title }}</h1>
        <p class="text-muted">Курс: {{ $course->title }}</p>

        @if($lesson->video_url)
            <div class="ratio ratio-16x9 mb-4">
                <iframe src="{{ $lesson->video_url }}" allowfullscreen></iframe>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Содержание урока</h5>
                <div>{!! nl2br(e($lesson->content)) !!}</div>
            </div>
        </div>

        @if($lesson->quiz)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Тест к уроку</h5>
                    <p>{{ $lesson->quiz->title }}</p>
                    <a href="{{ route('quizzes.take', $lesson->quiz) }}" class="btn btn-primary">Пройти тест</a>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        @can('update', $course)
            <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="btn btn-warning w-100 mb-2">Редактировать урок</a>
            
            @if(!$lesson->quiz)
                <a href="{{ route('quizzes.create', $lesson) }}" class="btn btn-success w-100 mb-2">Добавить тест</a>
            @endif
            
            <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('Удалить урок?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100">Удалить урок</button>
            </form>
        @endcan

        <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-secondary w-100 mt-2">Все уроки</a>
    </div>
</div>
@endsection
