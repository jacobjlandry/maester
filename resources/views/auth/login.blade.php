@extends('welcome')

@section('content')
<div class="ui container raised segment" style="display: flex; flex-direction: column;">
    <h3>Login</h3>
    <form method="post" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;">
                E-Mail
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;">
                Password
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;"></div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <div><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</div>
            </div>
        </div>
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;"></div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; justify-content: space-between;">
                <button type="submit" class="ui button blue">
                    Login
                </button>

                <a href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
