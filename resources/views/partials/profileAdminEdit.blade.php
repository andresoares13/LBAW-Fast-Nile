<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Edit Admin Profile Information</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Update your profile</h3>    
          <form action="/editAdmin" id="auctionForm" method="POST" class="profile" style="margin-top:60px;">

            {{ csrf_field() }}

            <div class="form-group">
              <div class="form-floating mb-3">
                <input id="name" type="text" name="name" value="<?=$admin->names?>"  class = "form-control" required="required">
                <label for="name">Name</label>
              </div>
            </div>

            
            <input type="hidden" name="admin" value="{{ Auth::guard('admin')->user()->id }}">

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Save</button>

            
          </form>
          </div>
      </div>
    </div>
  </div>  
</section>


