@extends('layouts.app')

@section('title', 'Calls Report')

@section('content')
    <div class="container mx-auto mt-8 mb-8 px-2">
        <h1 class="font-medium">Calls Report</h1>

        <hr class="border border-grey-lighter my-8">

        <calls-report :users="{{ $users }}"></calls-report>
    </div>
@endsection
