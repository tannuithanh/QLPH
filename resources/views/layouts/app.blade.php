<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS của bạn --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.header')

    <main class="flex-grow-1 py-6 w-full   ">
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    @include('partials.footer')
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
