<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="ltr">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <!-- TODO: this page needs to extend app.blade.php so this scrip is automatically imported -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140653687-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-140653687-1');
        </script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Yadu') }}</title>
        <link rel="icon" type="image/png" href="/images/favicon.png" />

        <script src="{{ asset('js/app.js') }}"></script>
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="main">
            <div id="header">
                @include('layouts.nav')
            </div>

            <!-- Optional -->
            @yield('banner')

			@yield('main')

            <div id="footer">
                @include('layouts.footer')
            </div>
        </div>
    </body>
</html>
