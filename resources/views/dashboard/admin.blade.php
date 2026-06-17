@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<h1>Панель администратора</h1>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Всего пользователей</h5>
                <h2>{{ $stats['total_users'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Всего курсов</h5>
                <h2>{{ $stats['total_courses'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Студентов</h5>
                <h2>{{ $stats['total_students'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Преподавателей</h5>
                <h2>{{ $stats['total_teachers'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Управление пользователями</h5>
                <p>Просмотр и редактирование всех пользователей системы</p>
                <a href="{{ route('admin.users') }}" class="btn btn-primary">Перейти</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Все курсы</h5>
                <p>Просмотр всех курсов в системе</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary">Перейти</a>
            </div>
        </div>
    </div>
</div>
@endsection
