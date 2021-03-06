<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix_url('css/app.css') }}" preload>

        @stack('meta')
    </head>
    <body>
        @yield('content')
    </body>
</html>
