@extends('layouts.app')

@section('title', 'Редактировать курс')

@section('content')
<h1>Редактировать курс</h1>

<form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="title" class="form-label">Название курса</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $course->title) }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cover_image" class="form-label">Обложка курса</label>
        @if($course->cover_image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $course->cover_image) }}" alt="Current cover" style="max-width: 200px;">
            </div>
        @endif
        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
        @error('cover_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Обновить курс</button>
    <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
