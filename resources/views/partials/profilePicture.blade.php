<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Change Profile Picture</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox">
        <h3>Upload Photo</h3>    
          <form action="/pictureProfile" method="POST" enctype="multipart/form-data" id="profilePictureEdit">
              
          {{ csrf_field() }}
              <label for="file"><div id='profile_image'>
              <img id="uploadPictureForm" src="{{asset('img/profile/' . $user->picture)}}" alt="ProfilePic">
            </div><br><br></label>
              <input class="form-control" type="file" name="image" required="required">
              <input type="hidden" name="user" value="{{ substr(strrchr(url()->current(),"/"),1) }}">
              <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Upload</button>
          </form>
          </div>
      </div>
    </div>
  </div>  
</section>           