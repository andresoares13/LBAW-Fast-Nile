<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Admin Profile: {{ $admin->names }}</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


<div class="col-xs-12 col-sm-6 col-md-4" style="margin-left: auto;margin-right:auto;margin-top:60px;margin-bottom:60px;min-height: calc(100vh - 358px);">
  <div class="frontside">
      <div class="card">
          <div class="card-body text-center">
              <p><img class=" img-fluid" src="{{asset('img/profileAdmin/' . $admin->picture)}}" alt="card image"></p>
              <h4 class="card-title"><strong>{{$admin->names}}</strong></h4>
              <h4 class="card-title">Admin</h4>
              <br>
              @if(auth()->guard('admin')->user()->id == substr(strrchr(url()->current(),"/"),1))
              <div id="profileOptions">
              @if (Session::get('info'))
                  <div class="alert alert-info">
                    {{Session::get('info')}}
                  </div>
                  @endif
                <a href="{{ url('/profileAdmin/edit/'. strval(auth()->guard('admin')->user()->id))}}">
                  <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Edit Profile Information</button> 
                </a>  
                <a href="{{route('register')}}">
                  <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Create New User</button> 
                </a>
                <a href="{{ url('/profileAdmin/picture/'. strval(auth()->guard('admin')->user()->id))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Change profile picture</button> 
                  </a>
                  <a href="{{ url('/users/blocked/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Blocked Users List</button> 
                  </a>  
              </div>
              @endif 
          </div>
      </div>
  </div>
</div>      





