
<section id="shadow">
    <div class="shadow-container">
      <div id="topAuctionCarousel" data-bs-interval="5000" class="carousel slide" data-bs-ride="true">
      <ol class="carousel-indicators">
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"> </li>
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="1" aria-label="Slide 2"> </li>
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="2" aria-label="Slide 3"></li>
      </ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url({{asset('img/backgrounds/b1.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[0]->getCarPicture($auctions[0]->idcar))}}" alt=""></div>
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[0]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[0]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[0]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url({{asset('img/backgrounds/b2.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[1]->getCarPicture($auctions[1]->idcar))}}" alt=""></div>  
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[1]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[1]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[1]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item" style="background-image: url({{asset('img/backgrounds/b3.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[2]->getCarPicture($auctions[2]->idcar))}}" alt=""></div>
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[2]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[2]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[2]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#topAuctionCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topAuctionCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>

      </div>
    </div>
  </section>

  <section id="closing" class="breadcrumbs" style="margin-top:0;">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center" >
          <h1 style="font-weight: bold;">Ending Soon: <a href="/auction/{{ $soonAuction->id }}">{{ $soonAuction->title }}</a></h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

  <section id="portfolio-details" class="portfolio-details" style="margin-bottom: 1%;">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                  <img id="auctionImageHome" src="{{asset('img/car/' . $soonAuction->getCarPicture($soonAuction->idcar))}}" alt="">
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Auction Details</h3>
              <ul>
                <li><strong>Owner</strong>: <a href="/profile/{{$soonAuction->getUser($soonAuction->owners)->id}}">{{$soonAuction->getAuctioneerName($soonAuction->owners)}}</a></li>
                <li><strong>Car</strong>: {{$soonAuction->getCar($soonAuction->idcar)->names}}</li>
                <li><strong>Type</strong>: {{$soonAuction->getCar($soonAuction->idcar)->category}}</li>
                <li><strong>State</strong>: {{$soonAuction->getCar($soonAuction->idcar)->states}}</li>
                <li><strong>Color</strong>: {{$soonAuction->getCar($soonAuction->idcar)->color}}</li>
                <li><strong>Consumption</strong>: {{$soonAuction->getCar($soonAuction->idcar)->consumption}} L/100km</li>
                <li><strong>Autonomy</strong>: {{$soonAuction->getCar($soonAuction->idcar)->kilometers}} km</li>
                <li style="font-size: larger;"><strong>Time Left</strong>: <text id='clock'></text></li>
                <li style="font-size: larger;"><strong>Current Price</strong><text id="currentPriceText">: {{$soonAuction->pricenow}} €</text></li>
                
          </div>
        </div>
      </div>
    </section><!-- End Portfolio Details Section -->



@php
$time = strtotime($soonAuction->toArray()['timeclose']);
@endphp
<script src="{{ asset('js/clock.js') }}" defer onload="startTime();"> </script>
<p hidden id = "hTime"><?php echo $time; ?></p>
<p hidden id = "soon">{{$soonAuction->id}}</p>