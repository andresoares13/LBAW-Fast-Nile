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
                  <h1 class="card-title text-center mb-5 "><strong> Register</strong></h1>
                  <form   method="POST" action="{{ route('register') }}">
                      {{ csrf_field() }}

                    <div class="form-floating mb-3">
                    <input type="text" id="names" class="form-control form-control-lg" name="names" value="{{ old('names') }}" required autofocus/>
                      <label for="floatingInput" style="color: black;">Name</label>
                      @if ($errors->has('names'))
                          <span class="error">
                          {{ $errors->first('names') }}
                          </span>
                      @endif
                    </div>
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

                    <div class="form-floating mb-3">
                    <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password_confirmation" required/>
                      <label for="floatingPassword" style="color: black;">Confirm Password</label>
                    </div>


                    <div class="d-grid">
                      <button id="buttonOver" class="btn btn-outline-light btn-lg px-5" style="width: 60%; margin-left:auto; margin-right:auto;" type="submit">Register</button>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid mb-2">
                    <div>
                      <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-white-50 fw-bold">Login</a>
                      </p>
                    </div>
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


        
  