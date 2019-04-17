<?php

namespace App\Http\Controllers\Api;

use App\Call;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index()
    {
        return Call::where('user_id', auth()->user()->id)
                   ->whereHas('events', function ($query) {
                       $query->where('event', 'initiated')
                             ->where('timestamp', '>', Carbon::now()->startOfDay());
                   })
//                   ->where('duration', '>', 0)
                   ->whereNotNull('user_id')
                   ->with(['user', 'events'])
                   ->latest()
                   ->get();
    }

    public function update(Request $request)
    {
        $inbound = str_contains($request->get('To'), 'client');

        $to = str_replace(['+', 'client:'], '', $request->get('To'));

        $from = str_replace(['+', 'client:'], '', $request->get('From'));

        $user = User::whereHas('number', function ($query) use ($request, $to, $from, $inbound) {
            $query->where('number', $inbound ? $to : $from);
        })->first();

        $call = Call::firstOrCreate([
            'client_sid' => $inbound ? $request->get('CallSid') : $request->get('ParentCallSid'),
        ]);

        $data = collect([
            'phone_sid' => $inbound
                ? $request->get('ParentCallSid')
                : $request->get('CallSid'),
            'direction' => $inbound ? 'inbound' : 'outbound-dial',
            'from'      => $from,
            'to'        => $to,
            'user_id'   => $user ? $user->id : null,
        ])->when($request->get('CallStatus') == 'completed', function ($data) use ($request) {
            $data->put('duration', $request->get('CallDuration'));

            $data->put('recording_sid', $request->get('RecordingSid'));

            return $data;
        });

        $call->update($data->toArray());

        $timestamp = Carbon::createFromFormat(
            'D, d M Y H:i:s O',
            $request->get('Timestamp')
        )->timezone('Europe/London');

        $call->events()->create([
            'event'         => $request->get('CallStatus'),
            'timestamp'     => $timestamp,
            'sequence_step' => $request->get('SequenceNumber'),
        ]);

        return response(['success' => 'true'], 200);
    }
}
