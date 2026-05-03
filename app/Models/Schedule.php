<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['teacher_id', 'subject_id', 'section', 'day', 'year_level', 'start_time', 'end_time', 'room'];

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id')->with('user'); 
    }
}
