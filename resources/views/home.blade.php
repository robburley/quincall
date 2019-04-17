@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen">
        <agent-stats></agent-stats>

        <div class="container mx-auto flex flex-wrap mt-4 mb-8 px-2">
            <div class="w-full sm:w-1/2 md:w-1/3 p-4">
                <h2 class="font-medium mb-8">Recent Calls</h2>

                <calls></calls>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/3 p-4">
                <h2 class="font-medium mb-8">Missed Calls</h2>

                <user-missed-calls :user_id="{{ auth()->id() }}"></user-missed-calls>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/3 p-4">
                <h2 class="font-medium mb-8">Voicemails</h2>

                <user-voicemails :user_id="{{ auth()->id() }}"></user-voicemails>
            </div>
        </div>

        <div class="fixed pin-r pin-b w-full md:w-64">
            <div class="flex items-center p-6">
                <dialler :user="{{ auth()->user() }}"></dialler>
            </div>
        </div>
    </div>
@endsection
