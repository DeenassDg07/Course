@extends('layouts.app')

@section('title', 'Создать тест')

@section('content')
<h1>Создать тест для урока: {{ $lesson->title }}</h1>

<form action="{{ route('quizzes.store', $lesson) }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label for="title" class="form-label">Название теста</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="passing_score" class="form-label">Проходной балл (%)</label>
        <input type="number" class="form-control @error('passing_score') is-invalid @enderror" id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" min="0" max="100" required>
        @error('passing_score')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <h3>Вопросы</h3>
    <div id="questions-container">
        <div class="question-block card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Вопрос 1</label>
                    <input type="text" class="form-control" name="questions[0][question_text]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Варианты ответов (каждый с новой строки)</label>
                    <textarea class="form-control" name="questions[0][options_text]" rows="4" required></textarea>
                    <small class="text-muted">Введите каждый вариант с новой строки</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Правильный ответ</label>
                    <input type="text" class="form-control" name="questions[0][correct_answer]" required>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">Добавить вопрос</button>
    <br>
    <button type="submit" class="btn btn-primary">Создать тест</button>
    <a href="{{ route('courses.lessons.show', [$lesson->course, $lesson]) }}" class="btn btn-secondary">Отмена</a>
</form>

<script>
let questionCount = 1;

function addQuestion() {
    const container = document.getElementById('questions-container');
    const newQuestion = document.createElement('div');
    newQuestion.className = 'question-block card mb-3';
    newQuestion.innerHTML = `
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Вопрос ${questionCount + 1}</label>
                <input type="text" class="form-control" name="questions[${questionCount}][question_text]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Варианты ответов (каждый с новой строки)</label>
                <textarea class="form-control" name="questions[${questionCount}][options_text]" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Правильный ответ</label>
                <input type="text" class="form-control" name="questions[${questionCount}][correct_answer]" required>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.question-block').remove()">Удалить вопрос</button>
        </div>
    `;
    container.appendChild(newQuestion);
    questionCount++;
}

// Обработка формы перед отправкой
document.querySelector('form').addEventListener('submit', function(e) {
    document.querySelectorAll('.question-block').forEach((block, index) => {
        const optionsText = block.querySelector('[name="questions[' + index + '][options_text]"]').value;
        const options = optionsText.split('\n').filter(opt => opt.trim() !== '');
        
        // Создаем скрытые поля для options
        options.forEach((opt, optIndex) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `questions[${index}][options][${optIndex}]`;
            input.value = opt.trim();
            block.appendChild(input);
        });
        
        // Удаляем текстовое поле
        block.querySelector('[name="questions[' + index + '][options_text]"]').remove();
    });
});
</script>
@endsection
