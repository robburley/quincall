<?php

namespace App\Http\Controllers\Api;

use App\Call;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AgentStatsController extends Controller
{
    public function index()
    {
        $callCount = Call::where('user_id', auth()->user()->id)
                         ->whereHas('events', function ($query) {
                             $query->where('event', 'initiated')
                                   ->where('timestamp', '>', Carbon::now()->startOfDay());
                         })
//            ->where('duration', '>', 0)
                         ->with('events')
                         ->count();

        $callTime = Call::where('user_id', auth()->user()->id)
                        ->whereHas('events', function ($query) {
                            $query->where('event', 'initiated')
                                  ->where('timestamp', '>', Carbon::now()->startOfDay());
                        })
//            ->where('duration', '>', 0)
                        ->with('events')
                        ->sum('duration');

        $averageDuration = Call::where('user_id', auth()->user()->id)
                               ->whereHas('events', function ($query) {
                                   $query->where('event', 'initiated')
                                         ->where('timestamp', '>', Carbon::now()->startOfDay());
                               })
//            ->where('duration', '>', 0)
                               ->with('events')
                               ->avg('duration');

        return [
            'call_count'       => $callCount,
            'call_time'        => $callTime,
            'average_duration' => $averageDuration,
        ];
    }
}
