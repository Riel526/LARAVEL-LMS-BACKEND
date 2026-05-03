<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{

    protected $scheduleService;


    public function __construct(ScheduleService $scheduleService) {
        $this->scheduleService = $scheduleService;
    }

    public function index(Request $request) : JsonResponse
    {
        $schedule = $this->scheduleService->getSchedule($request);

        return response()->json($schedule, 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Schedule $schedule)
    {
        //
    }
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    public function destroy(Schedule $schedule)
    {
        //
    }
}
