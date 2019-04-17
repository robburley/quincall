<?php

namespace App\Http\Controllers\Api\Reports;

use App\Call;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class CallReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end'   => 'required',
            'from'  => 'nullable|phone:AUTO,GB',
            'to'    => 'nullable|phone:AUTO,GB',
        ]);

        $start = Carbon::parse($request->get('start'));
        $end = Carbon::parse($request->get('end'));

        $from = !empty($request->get('from'))
            ? str_replace('+', '', PhoneNumber::make($request->get('from'), 'GB'))
            : null;

        $to = !empty($request->get('to'))
            ? str_replace('+', '', PhoneNumber::make($request->get('to'), 'GB'))
            : null;

        return Call::whereBetween('created_at', [$start, $end])
                   ->when(!empty($request->get('from')), function ($query) use ($from) {
                       $query->where('from', $from);
                   })
                   ->when(!empty($request->get('to')), function ($query) use ($to) {
                       $query->where('to', $to);
                   })
                   ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                       $query->where('user_id', $request->get('user_id'));
                   })
                   ->with(['events', 'recording', 'user'])
                   ->latest()
                   ->get()
                   ->map(function ($call) {
                       $timestamp = $call->events->filter(function ($event) {
                           return $event->where('event', 'initiated');
                       })->first();

                       return [
                           'id'            => $call->id,
                           'timestamp'     => $timestamp ? $timestamp->created_at->toIso8601ZuluString() : null,
                           'direction'     => $call->direction,
                           'from'          => $call->from,
                           'to'            => $call->to,
                           'duration'      => $call->duration,
                           'user_name'     => $call->user ? $call->user->name : null,
                           'recording_url' => $call->recording ? route('calls.recording.show', $call) : null,
                           'status'        => $call->events->last()
                               ? str_replace('-', ' ', title_case($call->events->last()->event))
                               : null,
                       ];
                   });
    }
}
