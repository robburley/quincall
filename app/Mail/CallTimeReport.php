<?php

namespace App\Mail;

use App\Call;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallTimeReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $calls = Call::with(['user', 'events'])
                     ->whereHas('events', function ($query) {
                         $query->where('event', 'initiated')
                               ->whereBetween('timestamp', [Carbon::now()->startOfDay(), Carbon::now()]);
                     })
//                     ->where('duration', '>', 0)
                     ->whereNotNull('user_id')
                     ->get();

        $users = $calls->groupBy(function ($call) {
            return $call->user->id;
        })->map(function ($calls) {
            return [
                'name' => $calls->first()->user->name,
                'first_call' => $calls->sortBy(function ($call) {
                    return $call->events->filter(function ($event) {
                        return $event->event == 'initiated';
                    })->first()->timestamp;
                })->first()->events->filter(function ($event) {
                    return $event->event == 'initiated';
                })->first()->timestamp,
                'last_call' => $calls->sortByDesc(function ($call) {
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

        return $this->from('notifications@call.quincomm.co.uk')
                    ->markdown('emails.reports.call-time')
                    ->with(['users' => $users]);
    }
}
