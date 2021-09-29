<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Currency Converter</title>

    <!-- Styles -->
    <link rel="stylesheet" href={{ asset('css/app.css') }}>
</head>

<body class="antialiased">
    <div id="app" class="container d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <app />
    </div>
</body>

<script src="{{ mix('js/app.js') }}"></script>

</html>