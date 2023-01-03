<script src="{{ asset('js/pages1.js') }}" defer onload="addEventListeners();"></script>
<main id="main"> 

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">My Wallet</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->
<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
  <div class="row gy-4">
          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                  <img id="walletImage" src="{{asset('img/backgrounds/b6.jpeg')}}" alt="">
              </div>
            </div>
          </div>
    <div class="col-lg-4">
            <div class="portfolio-info bidFormBox">
              <h3>Add Funds</h3>
              <ul>
                <li  ><strong>Current Funds: </strong> <text id="currentFunds">{{ Auth::user()->wallet }} €<text></li>
                <li>
                <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                <form action="{{ url('/api/wallet')}}" method="POST" target="dummyframe" id="walletForm" class="profile" onsubmit="return checkWalletValue()">
                  <label for="funds">Choose the amount you want to add <br> <br></label>
                    
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                    <input id="fundsInput" type="text" class="form-control form-control-lg" onkeypress="return checkNumber(event)" name="funds" value="500" required autofocus>
                    <span class="input-group-text">€</span>
                    </div>
                    <label id="error"></label> <br>
                    <input id="formUser" type="hidden" name="user" value="{{ Auth::user()->id }}">
                    <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" onclick="return checkWalletValue()" >Add Funds</button>
                </form>
                </li>
                <li><br><small>If you add enough funds maybe you will be able to buy a car like the one in the picture</small> </li>
              </ul>
            </div>
          </div>
      </div>
    </div>
  </section>    
<main>



