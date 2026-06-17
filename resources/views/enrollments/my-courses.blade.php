@extends('layouts.app')

@section('title', 'Мои курсы')

@section('content')
<h1>Мои курсы</h1>

<div class="row">
    @forelse($enrollments as $enrollment)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                    <p class="card-text">{{ Str::limit($enrollment->course->description, 100) }}</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Прогресс: {{ $enrollment->progress }}%</label>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ $enrollment->progress }}%">
                                {{ $enrollment->progress }}%
                            </div>
                        </div>
                    </div>

                    @if($enrollment->completed_at)
                        <div class="alert alert-success">
                            ✓ Курс завершен {{ $enrollment->completed_at->format('d.m.Y') }}
                        </div>
                    @endif

                    <a href="{{ route('courses.show', $enrollment->course) }}" class="btn btn-primary">Продолжить обучение</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Вы пока не записаны ни на один курс. 
                <a href="{{ route('courses.index') }}">Посмотреть доступные курсы</a>
            </div>
        </div>
    @endforelse
</div>
@endsection
