<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel App')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSS của bạn --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.header')

    <main class="flex-grow-1 d-flex flex-column animate-main" id="fadeTarget">
        <div class="page-content flex-grow-1">
            <div class="container-fluid px-0">
                @yield('content')
            </div>
        </div>
    </main>

    @include('partials.footer')
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('srcipts')
</body>


</html>
