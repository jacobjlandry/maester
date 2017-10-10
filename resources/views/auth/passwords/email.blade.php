@extends('welcome')

@section('content')
<div class="ui container raised segment" style="display: flex; flex-direction: column;">
    <h3>Reset Password</h3>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
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
            <div style="width: 15%; display: flex; align-items: center;"></div>
            <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                <button type="submit" class="ui button blue">
                    Send Password Reset Link
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
