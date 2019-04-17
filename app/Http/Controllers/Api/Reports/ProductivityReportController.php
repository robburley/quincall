<?php

namespace App\Http\Controllers\Api\Reports;

use App\Call;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductivityReportController extends Controller
{
    public function index(Request $request)
    {
        $calls = Call::with(['user', 'events'])
                     ->whereHas('events', function ($query) use ($request) {
                         $query->where('event', 'initiated')
                               ->whereBetween(
                                   'timestamp',
                                   [Carbon::parse($request->get('start')), Carbon::parse($request->get('end'))]
                               );
                     })
//                     ->where('duration', '>', 0)
                     ->whereNotNull('user_id')
                     ->get();

        $users = $calls->groupBy(function ($call) {
            return $call->user->id;
        })->map(function ($calls) {
            return [
                'name'                  => $calls->first()->user->name,
                'first_call'            => $calls->sortBy(function ($call) {
                    return $call->events->filter(function ($event) {
                        return $event->event == 'initiated';
                    })->first()->timestamp;
                })->first()->events->filter(function ($event) {
                    return $event->event == 'initiated';
                })->first()->timestamp,
                'last_call'             => $calls->sortByDesc(function ($call) {
                    return $call->events->filter(function ($event) {
                        return $event->event == 'initiated';
                    })->first()->timestamp;
                })->first()->events->filter(function ($event) {
                    return $event->event == 'initiated';
                })->first()->timestamp,
                'total_calls'           => $calls->count(),
                'inbound_calls'         => $calls->where('direction', 'inbound')->count(),
                'outbound_calls'        => $calls->where('direction', 'outbound-dial')->count(),
                'total_call_time'       => $calls->sum('duration'),
                'average_call_duration' => $calls->avg('duration'),
            ];
        })->sortBy('total_call_time');

        return $users;
    }
}
