@extends('welcome')

@section('content')
    <div class="ui container raised segment">
        <div class="welcome-banner">
            <div class="ui raised segment">
                        <span class="fa-stack fa-lg welcome-banner-icon fa-2x">
                          <i class="fa fa-square fa-stack-2x"></i>
                          <i class="fa fa-exclamation fa-stack-1x"></i>
                        </span>
                <span class="welcome-banner-content">
                    {{ $exception->getMessage() }}
                </span>
            </div>
        </div>
    </div>
@endsection