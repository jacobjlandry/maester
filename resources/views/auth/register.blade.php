@extends('welcome')

@section('content')
<div class="ui container raised segment" style="display: flex; flex-direction: column;">
    <h3>Register</h3>
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;">
                Name
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
            <div style="width: 15%; display: flex; align-items: center;">
                E-Mail
            </div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
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
                    Register
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
