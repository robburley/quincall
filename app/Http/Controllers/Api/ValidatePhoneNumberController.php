<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class ValidatePhoneNumberController extends Controller
{
    public function store(Request $request)
    {
        return PhoneNumber::make($request->get('phoneNumber'), 'GB');
    }
}
