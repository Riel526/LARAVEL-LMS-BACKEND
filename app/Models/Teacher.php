<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Teacher extends Model
{
    use HasFactory;
    protected $primaryKey = 'teacher_id';


    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
        'specialization',
        'is_active'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

}
