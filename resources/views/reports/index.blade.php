@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="container mx-auto mt-8 mb-8 px-2">
        <h1 class="font-medium">Reports</h1>

        <hr class="border border-grey-lighter my-8">

        <div class="flex flex-wrap">
            <div class="w-full sm:w-1/2 md:w-1/4">
                <div class="w-full flex items-center justify-center">
                    <div class="w-full overflow-hidden leading-normal">
                        <a href="{{ route('reports.calls.index') }}"
                           class="block group no-underline p-4 border-b border-grey-lighter">
                            <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">Calls</p>
                            <p class="text-sm mb-2 text-grey-darker group-hover:text-grey-darkest">View call logs for
                                any date range</p>
                        </a>

                        <a href="{{ route('reports.productivity.index') }}"
                           class="block group no-underline p-4 border-b border-grey-lighter">
                            <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">Productivity</p>
                            <p class="text-sm mb-2 text-grey-darker group-hover:text-grey-darkest">View user
                                productivity statistics</p>
                        </a>

                        <a href="{{ route('reports.status.index') }}" class="block group no-underline p-4">
                            <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">Status</p>
                            <p class="text-sm mb-2 text-grey-darker group-hover:text-grey-darkest">View user statuses in
                                real time</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full sm:w-1/2 md:w-3/4">
                <stats></stats>
            </div>
        </div>
    </div>
@endsection
