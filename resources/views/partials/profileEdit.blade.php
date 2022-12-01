<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Edit Profile Information</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Update your profile</h3>
        <form action="/edit" method="POST" style="margin-top:60px;">

          {{ csrf_field() }}
          <div class="form-group">
            <div class="form-floating mb-3">
              <input id="fundsInput" type="text" name="name" value="<?=$user->names?>"  class="form-control" required="required">
              <label for="fundsInput">Name</label>
            </div>
            <div class="form-floating mb-3">
              <input id="fundsInput" type="text" name="address" value="<?=$user->address?>" class="form-control" required="required">
              <label for="fundsInput">Address</label>
            </div>

          <?php if (count($auctioneer) != 0) { ?>
            <div class="form-floating mb-3">
              <input id="fundsInput" type="text" name="phone" value="<?=$auctioneer[0]["phone"]?>" class="form-control " required="required" minlength="5" maxlength="15">
              <label for="fundsInput">Phone</label>
            </div>
          <?php } ?>

          </div>
          
          <input type="hidden" name="user" value="{{ substr(strrchr(url()->current(),"/"),1) }}">

          <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Save</button>

          <p id="error_messages" style="color: black">
            <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
          </p>
        </form>
        </div>
      </div>
    </div>
  </div>  
</section>  