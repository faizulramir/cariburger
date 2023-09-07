<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="Cari Burger" name="description" />
        <meta content="fzlxtech" name="author" />
        <title>Cari Burger</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/icon.png') }}">
        @yield('css')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body style="background-image: url({{ asset('img/icon.png') }});">
        <div class="main-content" style="padding-top: 10px;">
            <div class="page-content">
                @yield('content')
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
    </body>
    @include('layouts.footer')
    @yield('script')
</html>
