<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/semantic/dist/semantic.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

        <!-- scripts -->
        <script   src="https://code.jquery.com/jquery-3.2.1.min.js"   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
        <script src="/semantic/dist/semantic.js" type="text/javascript"></script>
        <script src="{{ asset('js/pdf.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.7.6/showdown.min.js" type="text/javascript"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                @stack('scripts')
            });
        </script>
    </head>
    <body>
        @if(Session::has('error'))
            <div class="ui icon message negative">
                <span class="fa-stack fa-2x">
                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                    <i class="fa fa-exclamation fa-stack-1x"></i>
                </span>
                <div class="content" style="margin-left: 15px;">
                    <div class="header">
                        Sorry!
                    </div>
                    <p>{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif
        <div class="navigation">
            <div class="ui secondary menu nav-menu">
                <a class="@if(active_nav('home')) active @endif item" href="/">
                    Home
                </a>
                <a class="@if(active_nav('project')) active @endif item" href="/project">
                    Projects
                </a>
                <a class="@if(active_nav('task')) active @endif item" href="/task">
                    Tasks
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
                        @if(Auth::user()->role('admin'))
                            <a class="ui item" href="/admin/users">
                                Users
                            </a>
                        @endif
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
            @if(isset($release) || isset($task))
                <div class="ui breadcrumb" style="padding: 5px;">
                    @if(isset($release) && !isset($project))
                        <a class="section" href="/project/{{ $release->project->id }}">{{ $release->project->name }}</a>
                        <div class="divider"> / </div>
                        <div class="active section">{{ $release->version }}</div>
                    @elseif(isset($task) && !isset($project))
                        <a class="section" href="/project/{{ $task->project->id }}">{{ $task->project->name }}</a>
                        <div class="divider"> / </div>
                        @if($task->release)
                            <a class="section" href="/release/{{ $task->release->id }}">{{ $task->release->version }}</a>
                            <div class="divider"> / </div>
                        @endif
                        <div class="active section">{{ $task->title }}</div>
                    @endif
                </div>
            @endif

            <div class="ui container space-waster">
                &nbsp;
            </div>
            @if(!Auth::user() && !isset($exception))
                <div class="welcome-banner">
                    <div class="ui raised segment">
                        <span class="fa-stack fa-lg welcome-banner-icon fa-2x">
                          <i class="fa fa-square fa-stack-2x"></i>
                          <i class="fa fa-star-half-empty fa-stack-1x"></i>
                        </span>
                        <span class="welcome-banner-content">
                            Welcome to Maester! <br />
                            Please <a href="/login">Login</a> or <a href="/register">Register</a> to continue.
                        </span>
                    </div>
                </div>
            @endif
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
