@extends('welcome')

@section('content')
<div class="ui container raised segment" style="display: flex; flex-direction: column;">
    <h3>Reset Password</h3>
    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;">
                E-Mail
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
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
            <div style="width: 15%; display: flex; align-items: center;">
                Confirm Password
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;"></div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <button type="submit" class="ui button blue">
                    Reset Password
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
