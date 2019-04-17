<?php

namespace App\Http\Controllers\Api;

use App\Call;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $callCount = Call::whereNotNull('user_id')
                         ->whereHas('events', function ($query) {
                             $query->where('event', 'initiated')
                                   ->where('timestamp', '>', Carbon::now()->startOfDay());
                         })
//                         ->where('duration', '>', 0)
                         ->with('events')
                         ->count();

        $callTime = Call::whereNotNull('user_id')
                        ->whereHas('events', function ($query) {
                            $query->where('event', 'initiated')
                                  ->where('timestamp', '>', Carbon::now()->startOfDay());
                        })
//                        ->where('duration', '>', 0)
                        ->with('events')
                        ->sum('duration');

        $averageDuration = Call::whereNotNull('user_id')
                               ->whereHas('events', function ($query) {
                                   $query->where('event', 'initiated')
                                         ->where('timestamp', '>', Carbon::now()->startOfDay());
                               })
//                               ->where('duration', '>', 0)
                               ->with('events')
                               ->avg('duration');

        return [
            'call_count'       => $callCount,
            'call_time'        => $callTime,
            'average_duration' => $averageDuration,
        ];
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
