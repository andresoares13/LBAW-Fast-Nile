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
                  
                  <h1 class="card-title text-center mb-5 "><strong> Reset Password</strong></h1>

                  @if (Session::get('info'))
                  <div class="alert alert-info">
                    {{Session::get('info')}}
                  </div>
                  @endif
                  @if (Session::get('fail'))
                  <div class="alert alert-danger">
                    {{Session::get('fail')}}
                  </div>
                  @endif
                  <form   method="POST" action="/resetPasswordConfirm">
                      {{ csrf_field() }}
                    

                      <div class="form-floating mb-3">
                    <input type="password" id="typePassword" class="form-control form-control-lg inputOverlay" name="password" required/>
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

                    <input type="hidden"  name="email" value="{{ $email }}">

                    <input type="hidden"  name="token" value="{{ $token }}">


                    <div class="d-grid">
                      <button id="buttonOver" class="btn btn-outline-light btn-lg px-5" style="width: 60%; margin-left:auto; margin-right:auto;margin-top:5%" type="submit">Reset</button>
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











