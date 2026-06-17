@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ $course->title }}</h1>
        <p class="text-muted">Преподаватель: {{ $course->teacher->name }}</p>
        
        @if($course->cover_image)
            <img src="{{ asset('storage/' . $course->cover_image) }}" class="img-fluid mb-4" alt="{{ $course->title }}">
        @endif
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Описание курса</h5>
                <p>{{ $course->description }}</p>
            </div>
        </div>

        @auth
            @if($isEnrolled)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Ваш прогресс</h5>
                        @php
                            $enrollment = $course->enrollments->where('student_id', auth()->id())->first();
                            $progress = $enrollment ? $enrollment->progress : 0;
                        @endphp
                        <div class="progress mb-2" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%">
                                {{ $progress }}%
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <div class="col-md-4">
        @auth
            @if(!$isEnrolled && auth()->user()->isStudent())
                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg w-100 mb-3">Записаться на курс</button>
                </form>
            @elseif($isEnrolled)
                <div class="alert alert-success">Вы записаны на этот курс</div>
            @endif

            @can('update', $course)
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning w-100 mb-2">Редактировать курс</a>
                <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-info w-100 mb-2">Управление уроками</a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Удалить курс?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Удалить курс</button>
                </form>
            @endcan
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">Войдите, чтобы записаться</a>
        @endauth
    </div>
</div>

@if($course->lessons->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <h3>Уроки курса</h3>
            <div class="list-group">
                @foreach($course->lessons as $lesson)
                    <a href="{{ route('courses.lessons.show', [$course, $lesson]) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $lesson->order }}. {{ $lesson->title }}</h5>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection
