<?php

namespace App\Http\Controllers\Api;

use App\Call;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Twiml;

class CallRequestController extends Controller
{
    public function store(Request $request)
    {
        $outbound = $request->input('phoneNumber') ?: false;

        $dialParameters = [
            'callerId'                => str_replace('client:', '+', $request->get('Caller')),
            'record'                  => 'record-from-ringing',
            'recordingStatusCallback' => route('api.calls.recordings.store'),
            'answerOnBridge'          => true,
        ];

        $statusParameters = [
            'statusCallback'      => route('api.calls.update'),
            'statusCallbackEvent' => 'initiated ringing answered completed',
        ];

        $response = new Twiml();

        if ($outbound) {
            $dial = $response->dial($dialParameters);
            $dial->number($outbound, $statusParameters);
        } else {
            $directDial = str_replace('+', '', $request->get('Called'));

            $user = User::whereHas('number', function ($query) use ($directDial) {
                $query->where('number', $directDial);
            })->first();

            if ($user->online && $user->available) {
                $dial = $response->dial($dialParameters);
                $dial->client($directDial, $statusParameters);
            } else {
                $call = Call::create([
                    'phone_sid' => $request->get('CallSid'),
                    'direction' => 'inbound',
                    'from'      => str_replace('+', '', $request->get('Caller')),
                    'to'        => $directDial,
                    'user_id'   => $user->id,
                ]);

                $call->events()->createMany([
                    [
                        'event'         => 'initiated',
                        'timestamp'     => $now = now()->subSeconds(2),
                        'sequence_step' => 0,
                    ],
                    [
                        'event'         => 'ringing',
                        'timestamp'     => $now->addSecond(),
                        'sequence_step' => 1,
                    ],
                    [
                        'event'         => 'no-answer',
                        'timestamp'     => $now->addSecond(),
                        'sequence_step' => 2,
                    ],
                ]);

                $response->say(
                    'The extension you dialled is currently unavailable. Please leave a message after the tone.',
                    [
                        'voice'    => 'alice',
                        'language' => 'en-GB',
                    ]
                );

                $response->record([
                    'action'                  => route('api.voicemails.store', [$user]),
                    'maxLength'               => 60,
                    'recordingStatusCallback' => route('api.voicemails.recordings.store'),
                ]);
            }
        }

        Log::info($response);

        return $response;
    }
}
