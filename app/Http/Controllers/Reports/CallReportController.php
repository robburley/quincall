<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CallReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.calls.index', [
            'users' => User::active()->pluck('name', 'id'),
        ]);
    }
}
