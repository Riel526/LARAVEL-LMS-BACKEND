<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssignmentQuestion;
use App\Models\Subject;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory;

    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'grade_level',
        'section',
        'title',
        'instructions',
        'due_date'
    ];

    public function questions() {
        return $this->hasMany(AssignmentQuestion::class, 'assignment_id', 'assignment_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

}
