@extends('layouts.app')

@section('title', 'Уроки курса')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Уроки курса: {{ $course->title }}</h1>
    @can('update', $course)
        <a href="{{ route('courses.lessons.create', $course) }}" class="btn btn-success">Добавить урок</a>
    @endcan
</div>

<div class="list-group">
    @forelse($lessons as $lesson)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">{{ $lesson->order }}. {{ $lesson->title }}</h5>
                @if($lesson->video_url)
                    <small class="text-muted">📹 Видео</small>
                @endif
                @if($lesson->quiz)
                    <small class="text-muted ms-2">📝 Тест</small>
                @endif
            </div>
            <div>
                <a href="{{ route('courses.lessons.show', [$course, $lesson]) }}" class="btn btn-sm btn-primary">Просмотр</a>
                @can('update', $course)
                    <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить урок?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                @endcan
            </div>
        </div>
    @empty
        <div class="alert alert-info">Уроки пока не добавлены</div>
    @endforelse
</div>

<a href="{{ route('courses.show', $course) }}" class="btn btn-secondary mt-3">Назад к курсу</a>
@endsection
