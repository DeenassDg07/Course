@extends('layouts.app')

@section('title', 'Редактировать пользователя')

@section('content')
<h1>Редактировать пользователя: {{ $user->name }}</h1>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Роль</label>
        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Студент</option>
            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Преподаватель</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Администратор</option>
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Обновить пользователя</button>
    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
