@extends('layouts.app')

@section('title', 'Productivity Report')

@section('content')
    <div class="container mx-auto mt-8 mb-8 px-2">
        <h1 class="font-medium">Productivity Report</h1>

        <hr class="border border-grey-lighter my-8">

        <productivity-report></productivity-report>
    </div>
@endsection
