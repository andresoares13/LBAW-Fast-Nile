<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Unblock Account</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Unblock User <a href="{{ url('/profile/'. substr(strrchr(url()->current(),"/"),1)) }}">{{$user->names}}</a></h3>    
          <form action="/unblock" method="POST" id="deleteForm" class="profile">

            {{ csrf_field() }}
            <label ><strong> The justification for their block was:  <br> <small>{{$block->justification}}</small></strong> <br> <br></label>
            
            <input type="hidden" name="block" value="{{ $block->id }}">

            @if (Session::get('fail'))
            <div class="alert alert-danger">
              {{Session::get('fail')}}
            </div>
            @endif

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Unblock</button>

          </form>
          </div>
      </div>
    </div>
  </div>  
</section> 