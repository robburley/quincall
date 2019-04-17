<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Voicemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class VoicemailRecordingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $voicemail = Voicemail::where('recording_sid', $request->get('RecordingSid'))->first();

        $url = $request->get('RecordingUrl') . '.mp3';

        $path = 'recordings/voicemails/' . $voicemail->user->id . '/vm-' . $voicemail->from . '-' . $voicemail->created_at->format('Ymd') . '-' . $voicemail->created_at->format('His') . '-' . $voicemail->id . '.mp3';

        $recording = file_get_contents($url);

        $store = Storage::disk('local')->put($path, $recording);

        $voicemail->update([
            'duration'     => $request->get('RecordingDuration'),
            'external_url' => $request->get('RecordingUrl'),
            'location'     => $path,
        ]);

        $twilio = new Client(config('services.twilio')['accountSid'], config('services.twilio')['authToken']);
        $twilio->recordings($voicemail->recording_sid)->delete();

        return response(['success' => 'true'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
