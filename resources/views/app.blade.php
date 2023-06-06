<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/42382cf9d2.js" crossorigin="anonymous"></script>
        
        <!-- Styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-sky-950">
        <div id="app">
            <task-list></task-list>
            <create-task :showing="false"></create-task>
         </div>
    </body>
</html>
