<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Создаем пользователей
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $student1 = User::create([
            'name' => 'Student One',
            'email' => 'student1@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'name' => 'Student Two',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Создаем курс
        $course = Course::create([
            'title' => 'Введение в Laravel',
            'description' => 'Изучите основы фреймворка Laravel с нуля',
            'teacher_id' => $teacher->id,
        ]);

        // Создаем уроки
        $lesson1 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Установка Laravel',
            'content' => 'В этом уроке мы установим Laravel...',
            'video_url' => 'https://www.youtube.com/watch?v=example1',
            'order' => 1,
        ]);

        $lesson2 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Маршрутизация',
            'content' => 'Изучим работу с маршрутами...',
            'video_url' => 'https://www.youtube.com/watch?v=example2',
            'order' => 2,
        ]);

        $lesson3 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Контроллеры',
            'content' => 'Создадим наш первый контроллер...',
            'video_url' => 'https://www.youtube.com/watch?v=example3',
            'order' => 3,
        ]);

        // Создаем тест для первого урока
        $quiz = Quiz::create([
            'lesson_id' => $lesson1->id,
            'title' => 'Тест по установке Laravel',
            'passing_score' => 70,
        ]);

        // Добавляем вопросы
        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Какая команда используется для создания нового проекта Laravel?',
            'options' => ['laravel new', 'composer create-project', 'php artisan new', 'npm create laravel'],
            'correct_answer' => 'composer create-project',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Какая минимальная версия PHP требуется для Laravel?',
            'options' => ['7.0', '7.4', '8.0', '8.1'],
            'correct_answer' => '8.0',
        ]);

        // Записываем студентов на курс
        $student1->enrolledCourses()->attach($course->id, ['progress' => 33]);
        $student2->enrolledCourses()->attach($course->id, ['progress' => 66]);
    }
}
