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

    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">


    
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    



  <title>Fast Nile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png')}}" rel="icon" type="image/png">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
      

  </head>
  <body>
    <header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid header-flex">
    <a class="navbar-brand" href="{{ url('/home') }}">Fast Nile</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @if(substr(strrchr(url()->current(),"/"),1) != ('login') && substr(strrchr(url()->current(),"/"),1) != ('register') && substr(strrchr(url()->current(),"/"),1) != ('admin'))
    <div class="navbar-collapse collapse show" id="navbarColor02" style="">
      <ul class="navbar-nav me-auto">
      @if (substr(strrchr(url()->current(),"/"),1) == ('home'))
        <li class="nav-item">
          <a class="nav-link active" href="#shadow">Top Auctions
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#closing">Closing Soon</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#faq">FAQ</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/home') }}">Home</a>
        </li>
        @endif
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Search</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/auctions/1') }}">Auctions</a>
            <a class="dropdown-item" href="{{ url('/users/1') }}">Users</a>
            <a class="dropdown-item" href="{{ url('/search')}}">Advanced Search</a>
        </li>
        @if (Auth::check())
        <li class="nav-item button">
          
          <a href="{{ url('/profile/'. strval(auth()->user()->id)) }}"><button id="buttonHeader">{{ Auth::user()->names }}</button></a>
        
        </li>
        <li class="nav-item">
        <a id="headerWallet" class="nav-link wallet" href="{{ url('/profile/wallet/'. strval(auth()->user()->id))}}">Wallet: {{ Auth::user()->wallet }} €</a>
        </li>
        <li class="nav-item button">
          
          <a href="{{ url('/logout')}}"><button id="buttonHeader">Logout</button></a>
        
        </li>
        @elseif (Auth::guard('admin')->check())
        <li class="nav-item button">
          
          <a href="{{ url('/profileAdmin/'. strval(auth()->guard('admin')->user()->id)) }}"><button id="buttonHeader">{{ Auth::guard('admin')->user()->names }}</button></a>
        
        </li>
        <li class="nav-item button">
          
          <a href="{{ url('/logout')}}"><button id="buttonHeader">Logout</button></a>
        
        </li>
        @else
        <li class="nav-item button">
          
          <a href="{{ url('/login')}}"><button id="buttonHeader">Login</button></a>
        
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
@endif

    
  </header><!-- End Header -->
  <main >
  
      <section id="content">
        @yield('content')
      </section>
    </main>

 

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
    <div class="container text-center">
      <small>Fast Nile | Email: fastnileweb@gmail.com | <a href="/aboutUs">About Us</a></small>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>    


</html>
