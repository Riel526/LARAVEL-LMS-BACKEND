<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Assignment;

class AssignmentQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentQuestionFactory> */
    use HasFactory;

    protected $casts = [
        'options' => 'array'
    ]; 

    protected $fillable = [
        'assignment_id',
        'type',
        'question_text',
        'correct_answer',
        'options',
        'points'
    ];

    protected function assignment () {
        return $this->belongsTo(Assignment::class);
    }
}
