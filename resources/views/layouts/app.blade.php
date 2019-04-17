<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
</head>

<body class="h-screen font-sans bg-grey-lightest">
    <div id="app">
        <nav class="flex items-center justify-between flex-wrap bg-grey-darkest p-6">
            <div class="flex items-center flex-no-shrink text-white mr-8">
                <a href="/" class="font-semibold text-xl tracking-tight text-white no-underline">{{ config('app.name', 'Laravel') }}</a>
            </div>

            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
                    {{-- <a href="#" class="block mt-4 no-underline lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4">
                        Test Environment
                    </a> --}}
                </div>

                <div>
                    @if (auth()->user()->isAdministrator())
                        <a href="{{ route('reports.index') }}" class="inline-block px-4 py-2 leading-none no-underline text-grey-light hover:text-white mt-4 lg:mt-0">
                            <i class="fas fa-chart-pie fa-fw"></i>
                        </a>

                        <a href="{{ route('settings.index') }}" class="inline-block px-4 py-2 leading-none no-underline text-grey-light hover:text-white mt-4 lg:mt-0">
                            <i class="fas fa-cog fa-fw"></i>
                        </a>
                    @endif

                    <a href="{{ route('logout') }}" class="inline-block px-4 py-2 leading-none no-underline text-grey-light hover:text-white mt-4 lg:mt-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-fw"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
