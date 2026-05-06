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

    protected function assignment () {
        $this->belongsTo(Assignment::class);
    }
}
