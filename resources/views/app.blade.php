<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How Worthy Am I?</title>
    <link rel="stylesheet" href="{{ resource_path('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ resource_path('assets/jquery/jquery.terminal.min.css') }}">
</head>

<body>
    <main class="container">
        @yield('content')
    </main>


    <script src="{{ resource_path('assets/jquery-terminal/jquery.terminal.min.js') }}"></script>
    <script src="{{ resource_path('assets/boostrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ resource_path('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ resource_path('assets/bootstrap/proper.min.js') }}"></script>
</body>
</html>