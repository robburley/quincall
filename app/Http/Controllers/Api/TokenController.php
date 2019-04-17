<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\ClientToken;

class TokenController extends Controller
{
    /**
     * Create a new capability token
     *
     * @param Request     $request
     * @param ClientToken $clientToken
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ClientToken $clientToken)
    {
        $clientToken->allowClientOutgoing(config('services.twilio')['applicationSid']);
        $clientToken->allowClientIncoming(auth()->user()->number->number);

        $token = $clientToken->generateToken();

        return response()->json(['token' => $token]);
    }
}
