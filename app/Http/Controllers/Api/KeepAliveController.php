<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class KeepAliveController extends Controller
{
    public function show()
    {
        if (auth()->check()) {
            return response(['success' => true], 200);
        }

        abort(401);
    }
}
