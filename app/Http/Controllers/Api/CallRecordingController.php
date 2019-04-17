<?php

namespace App\Http\Controllers\Api;

use App\Call;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class CallRecordingController extends Controller
{
    public function store(Request $request)
    {
        $call = Call::where('recording_sid', $request->get('RecordingSid'))->first();

        $url = $request->get('RecordingUrl') . '.mp3';

        $path = 'recordings/calls/' . $call->user->id . '/call-' . $call->from . '-' . $call->to . '-' . $call->created_at->format('Ymd') . '-' . $call->created_at->format('His') . '-' . $call->id . '.mp3';

        $recording = file_get_contents($url);

        $store = Storage::disk('local')->put($path, $recording);

        $call->recording()->create([
            'duration'     => $request->get('RecordingDuration'),
            'location'     => $path,
        ]);

        $twilio = new Client(config('services.twilio')['accountSid'], config('services.twilio')['authToken']);
        $twilio->recordings($call->recording_sid)->delete();

        return response(['success' => 'true'], 200);
    }
}
