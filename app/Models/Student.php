<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'lrn',
        'first_name', 
        'last_name', 
        'middle_name', 
        'email', 
        'grade_level', 
        'section', 
        'is_active',
        'password',
        'gwa',
        'birth_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gwa' => 'float',
        'birth_date' => 'date'
    ];
    //
}
