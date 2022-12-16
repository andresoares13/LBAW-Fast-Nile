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
                  <h1 class="card-title text-center mb-5 "><strong>Forgot Password</strong></h1>
                  @if (Session::get('success'))
                  <div class="alert alert-info">
                    {{Session::get('success')}}
                  </div>
                  @endif
                  <form   method="POST" action="/resetPassword">
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
                    <div class="d-grid">
                      <button id="buttonOver" class="btn btn-outline-light btn-lg px-5" style="width: 90%; margin-left:auto; margin-right:auto;margin-top: 5%;" type="submit">Send Password Reset Link</button>
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











