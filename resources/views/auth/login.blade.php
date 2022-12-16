@extends('layouts.app')


<section id="shadow" class="login">
  <div class="shadow-container">
    <div class="carousel-inner" role="listbox">
      <div class="carousel-item active" style="background-image: url({{asset('img/backgrounds/b4.jpg')}});">
        <section class=" gradient-custom">
        <div class="container" id="loginForms">
          <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
              <div class="card border-0 shadow rounded-3 my-5 bg-dark" style="color: white;">
                <div class="card-body p-4 p-sm-5">
                  @isset($url)
                  <h1 class="card-title text-center mb-5"><strong>Admin Login</strong></h1>
                  <form  method="POST" action="{{ url('login/admin') }}">
                  @else
                  <h1 class="card-title text-center mb-5 "><strong> User Login</strong></h1>
                  @if (Session::get('info'))
                  <div class="alert alert-info">
                    {{Session::get('info')}}
                  </div>
                  @endif
                  <form   method="POST" action="{{ route('login') }}">
                  @endisset
                      {{ csrf_field() }}
                    <div class="form-floating mb-3">
                    <input type="email" id="typeEmailX" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autofocus/>
                      <label for="floatingInput" style="color: black;">Email address</label>
                      @if ($errors->has('email'))
                          <span class="error">
                          {{ $errors->first('email') }}
                          </span>
                      @endif
                    </div>
                    <div class="form-floating mb-3">
                    <input type="password" id="typePasswordX" class="form-control form-control-lg inputOverlay" name="password" required/>
                      <label for="floatingPassword" style="color: black;">Password</label>
                      @if ($errors->has('password'))
                          <span class="error">
                              {{ $errors->first('password') }}
                          </span>
                      @endif
                    </div>

                    <div class="form-check mb-3">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me

                      <br>
                      <label class="form-check-label"><a class="text-white-50" href="{{ url('/forgotPassword') }}">Forgot password?</a></label>
                    </div>
                    <div class="d-grid">
                      <button id="buttonOver" class="btn btn-outline-light btn-lg px-5" style="width: 60%; margin-left:auto; margin-right:auto;" type="submit">Login</button>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid mb-2">
                    @isset($url)
                    @else
                    <div>
                      <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-white-50 fw-bold">Sign Up</a>
                      </p>
                    </div>
                    <br>
                    @endisset
                    
                    @isset($url)
                      <a id="buttonOver" style="width: 75%; margin-left:auto; margin-right:auto;" class="btn btn-outline-light btn-lg px-5" href="{{url('login')}}">
                          User Login
                      </a>
                      @else
                      <a id="buttonOver" style="width: 80%; margin-left:auto; margin-right:auto;" class="btn btn-outline-light btn-lg px-5" href="{{url('login/admin')}}">
                          Admin Login
                      </a>
                      @endisset
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        </section>
      </div>
    </div>
  </div>
</section>











