<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'lrn',
        'user_id',
        'grade_level', 
        'section', 
        'is_active',
        'password',
        'gwa',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gwa' => 'float',
    ];
    

    public function user() {
        return $this->belongsTo(User::class);
    }
}
