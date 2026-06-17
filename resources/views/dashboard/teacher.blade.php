@extends('layouts.app')

@section('title', 'Панель преподавателя')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Мои курсы</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-success">Создать новый курс</a>
</div>

<div class="row">
    @forelse($courses as $course)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>📚 Уроков: {{ $course->lessons_count }}</span>
                        <span>👥 Студентов: {{ $course->students_count }}</span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-primary">Просмотр</a>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-sm btn-info">Уроки</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">У вас пока нет созданных курсов</div>
        </div>
    @endforelse
</div>
@endsection
