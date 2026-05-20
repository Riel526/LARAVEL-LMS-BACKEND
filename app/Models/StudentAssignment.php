<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $table = 'student_assignments';

    protected $fillable = [
        'student_id',
        'assignment_id',  
        'total_score',
        'max_score',
        'answers_snapshot',
        'completed_at'
    ];

    protected $casts = [
        'answers_snapshot' => 'array', 
        'completed_at' => 'datetime',
    ];


    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'assignment_id');
    }
}
