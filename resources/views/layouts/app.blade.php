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
        <h1><a href="{{ url('/home') }}">Fast Nile</a></h1>
        @if (Auth::check())
        <p>
        <a class='button' href="{{ url('/profile/'. strval(auth()->user()->id.'/wallet')) }}">Wallet: {{ Auth::user()->wallet }}</a>
        <a class='button' href="{{ url('/profile/'. strval(auth()->user()->id)) }}">{{ Auth::user()->names }}</a> 
        <a class="button" href="{{ url('/logout') }}"> Logout </a> 
        </p>
        <p>
        <form id="formSearch" action="{{ url('/search') }}" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search..."
          aria-label="Search through site content">
          <button type='submit'>
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        </form>
        </p>
        
        @elseif (substr(strrchr(url()->current(),"/"),1) != ('login') && substr(strrchr(url()->current(),"/"),1) != ('register'))
        <form id="formSearch" action="{{ url('/search') }}" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search..."
          aria-label="Search through site content">
          <button type='submit'>
          <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
          </button>
        </form>
        <a class="button" href="{{ route('register') }}">Register</a> <a class="button" href="{{ url('/login') }}"> Login </a> 
        @else
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
