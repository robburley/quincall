<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function index()
    {
        return view('home');
    }
}
