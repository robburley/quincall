@extends('layouts.app')

@section('title', 'Status Report')

@section('content')
    <div class="container mx-auto mt-8 mb-8 px-2">
        <h1 class="font-medium">Status Report</h1>

        <hr class="border border-grey-lighter my-8">

        <status-report></status-report>
    </div>
@endsection
