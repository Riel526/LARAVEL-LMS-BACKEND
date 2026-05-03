<?php


namespace App\Services;
use Illuminate\Http\Request;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService {

  public function getSchedule (Request $request) {
    $user = $request->user();
    $student = $user->student;
    if (!$user || !$user->student) {
        return collect();
    }
    
    return Schedule::where('section', $student->section)
    ->where('year_level', $student->grade_level)
    ->with(['subject', 'teacher.user:id,first_name,last_name'])
    ->get();
  }

}