<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {
    protected $fillable = ['course_id', 'title', 'position', 'content_type', 'content'];

    public function course() { return $this->belongsTo(Course::class); }
    public function quiz() { return $this->hasOne(Quiz::class); }
    public function progressRecords() { return $this->hasMany(LessonProgress::class); }
}
