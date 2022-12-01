<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Become An Auctioneer</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Upgrade Your Profile</h3>    
          <form action="/upgrade" method="POST" id="upgradeForm" class="profile">

            {{ csrf_field() }}


            <label for="phone"><strong> To become an auctioneer, please enter your phone number. <br> After Upgrading you will be able to create and manage auctions</strong> <br> <br></label>
            <script src="{{ asset('js/pages1.js') }}"></script>
            <div class="form-group">
              <div class="form-floating mb-3">
                <input id="phone" type="text" name="phone" class = "form-control" onkeypress="return checkNumber(event)" required="required" minlength="5" maxlength="15">
                <label for="phone">Phone</label>
            </div>
            </div>

            
            <input type="hidden" name="user" value="{{ Auth::user()->id }}">

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Upgrade</button>

            <p id="error_messages" style="color: black">
              <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
            </p>
          </form>
          </div>
      </div>
    </div>
  </div>  
</section> 