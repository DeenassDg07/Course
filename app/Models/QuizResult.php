<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model {
    protected $fillable = ['user_id', 'quiz_id', 'score', 'passed', 'taken_at'];
    protected $casts = ['passed' => 'boolean', 'taken_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function quiz() { return $this->belongsTo(Quiz::class); }
}
