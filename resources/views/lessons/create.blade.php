@extends('layouts.app')

@section('title', 'Добавить урок')

@section('content')
<h1>Добавить урок в курс: {{ $course->title }}</h1>

<form action="{{ route('courses.lessons.store', $course) }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label for="title" class="form-label">Название урока</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Содержание урока</label>
        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8">{{ old('content') }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="video_url" class="form-label">URL видео (необязательно)</label>
        <input type="url" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url') }}">
        @error('video_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="order" class="form-label">Порядок урока</label>
        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $course->lessons->count() + 1) }}" min="0" required>
        @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Добавить урок</button>
    <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
