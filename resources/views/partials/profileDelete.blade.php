<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Delete Account</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Are you sure you want to delete your account?</h3>    
          <form action="/delete" method="POST" id="deleteForm" class="profile">

            {{ csrf_field() }}


            <label ><strong> This will permanently delete your account. <br> <small>Forever is a long time.</small></strong> <br> <br></label>
            
            <input type="hidden" name="user" value="{{ Auth::user()->id }}">

            @if (Session::get('fail'))
            <div class="alert alert-danger">
              {{Session::get('fail')}}
            </div>
            @endif

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Delete</button>

          </form>
          </div>
      </div>
    </div>
  </div>  
</section> 