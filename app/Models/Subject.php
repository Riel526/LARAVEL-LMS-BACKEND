<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $primaryKey = 'subject_id';


    protected $fillable = [
        'subject_code',
        'name',
        'description',
        'units',
        'category',
        'image_path',
        'is_active',
    ];
}
