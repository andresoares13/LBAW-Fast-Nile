@extends('layouts.app')

@section('content')

@isset($url)
<form method="POST" action="{{ url('login/admin') }}">
<p id="loginType">Admin Login</p>
@else
<form method="POST" action="{{ route('login') }}">
<p id="loginType">User Login</p>
@endisset
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <div class="buttonHolder">
    <button type="submit">
        Login
    </button>
    @isset($url)
    @else
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
    @endisset
    </div>
    <br>
    @isset($url)
    <a id="loginTypeButton" href="{{url('login')}}"><button type="button">
        User Login
    </button></a>
    @else
    <a id="loginTypeButton" href="{{url('login/admin')}}"><button type="button">
        Admin Login
    </button></a>
    @endisset
</form>
@endsection
