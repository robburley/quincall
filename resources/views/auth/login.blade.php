<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="h-screen font-sans bg-grey-lightest">
    <div id="app">
        <div class="flex justify-center items-center w-full h-screen">
            <div class="w-full max-w-sm">
                <h1 class="font-medium tracking-wide text-center mb-4">Welcome to {{ config('app.name', 'Laravel') }} 👋</h1>

                <p class="font-light text-center text-grey-dark mb-4">Log in to start dialling</p>

                <form method="POST" action="{{ route('login') }}" class="px-8 pt-6 pb-8 mb-4">
                    {{ csrf_field() }}

                    <div class="mb-6">
                        <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="email">Email Address</label>
                        <input class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight{{ $errors->has('email') ? ' border-red mb-2' : '' }}" id="email" name="email" type="text" value="{{ old('email') }}" placeholder="Email Address" required autofocus>

                        {!! $errors->first('email', '<span class="text-red text-cs italic">:message</span>') !!}
                    </div>

                    <div class="mb-6">
                        <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="password">Password</label>
                        <input class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight{{ $errors->has('password') ? ' border-red mb-2' : '' }}" id="password" name="password" type="password" placeholder="Password" required>

                        {!! $errors->first('password', '<span class="text-red text-cs italic">:message</span>') !!}
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <span class="text-sm text-grey-dark"><input class="mr-2 leading-tight" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Keep me logged in</span>

                        <a class="inline-block align-baseline no-underline text-sm text-blue-light hover:text-blue" href="#">
                            Forgot your password?
                        </a>
                    </div>

                    <button class="w-full bg-blue hover:bg-blue-dark text-white font-light py-4 rounded" type="submit">Log In</button>
                </form>

                <p class="text-center text-grey text-xs">
                    &copy 2018 All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
