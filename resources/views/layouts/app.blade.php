<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <h1 id="SiteName" ><a href="{{ url('/home') }}">Fast Nile</a></h1>
        @if (Auth::check())
        <p id ="headerUser">
        <a class='button' href="{{ url('/profile/'. strval(auth()->user()->id)) }}">{{ Auth::user()->names }}</a> 
        <a class='button' href="{{ url('/profile/wallet/'. strval(auth()->user()->id)) }}">Wallet: {{ Auth::user()->wallet }} €</a>
        <a class="button" href="{{ url('/logout') }}"> Logout </a> 
        </p>

        <p id="headerAccess">
        <a class='button' href="{{ url('/search')}}">Search</a> 
        <a class='button' href="{{ url('/users/1') }}">Users</a>
        <a class="button" href="{{ url('/auctions/1') }}"> Auctions </a> 
        </p>
        
        
        @elseif (substr(strrchr(url()->current(),"/"),1) != ('login') && substr(strrchr(url()->current(),"/"),1) != ('register'))
        <p id ="headerUser">
        <a class="button" href="{{ route('register') }}">Register</a> <a class="button" href="{{ url('/login') }}"> Login </a> 
        </p>
        <p id="headerAccess">
        <a class='button' href="{{ url('/search')}}">Search</a> 
        <a class='button' href="{{ url('/users/1') }}">Users</a>
        <a class="button" href="{{ url('/auctions/1') }}"> Auctions </a> 
        </p>
        @else
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
