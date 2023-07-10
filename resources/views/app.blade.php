<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/42382cf9d2.js" crossorigin="anonymous"></script>
        
        <!-- Styles & Scripts -->
        @foreach($css_includes as $css)
            <link rel="stylesheet" href="{{ asset("build/assets/" . $css) }}" />
        @endforeach

        @foreach($js_includes as $js)
            <script type="text/javascript" src="{{ asset("build/assets/" . $js) }}"></script>
        @endforeach
        
        <!-- keep this in case we're in dev mode -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="antialiased bg-sky-950">
        <div id="app">
            <task-list></task-list>
         </div>
    </body>
</html>
