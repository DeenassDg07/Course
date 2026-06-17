@extends('layouts.app')

@section('title', 'Все курсы')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Все курсы</h1>
    </div>
</div>

<div class="row">
    @forelse($courses as $course)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($course->cover_image)
                    <img src="{{ asset('storage/' . $course->cover_image) }}" class="card-img-top" alt="{{ $course->title }}">
                @else
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-white">Нет изображения</span>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                    <p class="text-muted small">Преподаватель: {{ $course->teacher->name }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Курсы пока не созданы</div>
        </div>
    @endforelse
</div>

{{ $courses->links() }}
@endsection
