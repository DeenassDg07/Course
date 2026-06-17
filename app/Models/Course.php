<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model {
    protected $fillable = ['title', 'slug', 'description', 'cover_image', 'difficulty', 'instructor_id', 'category_id', 'is_published'];
    protected $casts = ['is_published' => 'boolean'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($course) { $course->slug = Str::slug($course->title); });
    }

    public function instructor() { return $this->belongsTo(User::class, 'instructor_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function lessons() { return $this->hasMany(Lesson::class)->orderBy('position'); }
    public function students() { return $this->belongsToMany(User::class, 'course_user')->withPivot('progress', 'enrolled_at', 'completed_at')->withTimestamps(); }
}
