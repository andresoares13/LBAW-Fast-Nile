<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Block Account</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Block Justification <br> User <a href="{{ url('/profile/'. substr(strrchr(url()->current(),"/"),1)) }}">{{$user->names}}</a></h3>    
          <form action="/block" method="POST" id="deleteForm" class="profile">

            {{ csrf_field() }}


            <div class="form-floating mb-3">
                <textarea id="descriptions" name="justification"  class = "form-control" required="required" minlength="3" maxlength="250" rows="4" cols="50" style="height:200px;"> </textarea>
                <label for="descriptions">Justification</label>
              </div> 
            
            <input type="hidden" name="user" value="{{ substr(strrchr(url()->current(),"/"),1) }}">

            @if (Session::get('fail'))
            <div class="alert alert-danger">
              {{Session::get('fail')}}
            </div>
            @endif

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Block</button>

          </form>
          </div>
      </div>
    </div>
  </div>  
</section> 