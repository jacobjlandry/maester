<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/semantic/dist/semantic.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

        <!-- scripts -->
        <script   src="https://code.jquery.com/jquery-3.2.1.min.js"   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
        <script src="/semantic/dist/semantic.js" type="text/javascript"></script>

        @stack('scripts')
    </head>
    <body>
        <div class="navigation">
            <div class="ui secondary menu nav-menu">
                <a class="active item" href="/">
                    Home
                </a>
                <a class="item" href="/project">
                    Projects
                </a>
                <a class="item">
                    Tickets
                </a>
                <div class="right menu">
                    <div class="item">
                        <div class="ui icon input">
                            <input type="text" placeholder="Search...">
                            <i class="search link icon"></i>
                        </div>
                    </div>
                    @if(Auth::user())
                        <a class="ui item">
                            Profile
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ui item">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    @else
                        <a href="/login" class="ui item">
                            Login
                        </a>
                        <a href="/register" class="ui item">
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div id="content" style="display: flex; flex-direction: column;">
            <div class="ui container space-waster">
                &nbsp;
            </div>
            @yield('content')
        </div>
        <div class="footer">
            <div class="left">
                &copy; Jacob Landry 2017
            </div>
            <div class="middle">
                <div>
                    <a href="">Blog</a>
                </div>
                <div>
                    <a href="">GameLib</a>
                </div>
                <div>
                    <a href=""">World Builder</a>
                </div>
            </div>
            <div class="right">
                <div>
                    <a href="https://twitter.com/jacoblandry">
                        Twitter &nbsp;&nbsp; <i class="fa fa-twitter"></i>
                    </a>
                </div>
                <div>
                    <a href="https://www.facebook.com/landry.jacob">
                        Facebook &nbsp;&nbsp; <i class="fa fa-facebook"></i>
                    </a>
                </div>
                <div>
                    <a href="https://www.linkedin.com/in/landryjacob/">
                        LinkedIn &nbsp;&nbsp; <i class="fa fa-linkedin"></i>
                    </a>
                </div>
                <div>
                    <a href="https://github.com/jacobjlandry">
                        Github &nbsp;&nbsp; <i class="fa fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
