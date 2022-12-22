<script src="{{ asset('js/pages1.js')}}" defer onload="addEventListeners();"></script>
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Auction Page: <a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details" >
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                  <img id="auctionImage" src="{{asset('img/car/' . $auction->getCarPicture($auction->idcar))}}" alt="">
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Auction Details</h3>
              <ul>
                @if ($auction->owners == null)
                <li><strong>Owner</strong>: Anonymous</li>
                @else
                <li><strong>Owner</strong>: <a href="/profile/{{$auction->getUser($auction->owners)->id}}">{{$auction->getAuctioneerName($auction->owners)}}</a></li>
                @endif
                <li><strong>Car</strong>: {{$auction->getCar($auction->idcar)->names}}</li>
                <li><strong>Type</strong>: {{$auction->getCar($auction->idcar)->category}}</li>
                <li><strong>State</strong>: {{$auction->getCar($auction->idcar)->states}}</li>
                <li><strong>Color</strong>: {{$auction->getCar($auction->idcar)->color}}</li>
                <li><strong>Consumption</strong>: {{$auction->getCar($auction->idcar)->consumption}} L/100km</li>
                <li><strong>Autonomy</strong>: {{$auction->getCar($auction->idcar)->kilometers}} km</li>
                @if ($auction->states != 'Closed')
                <li style="font-size: larger;"><strong>Time Left</strong>: <text id='clock'></text></li>
                <li style="font-size: larger;"><strong>Current Price</strong><text id="currentPriceText">: {{$auction->pricenow}} €</text></li>
                <li>
                @if (auth()->guard('admin')->check())
                    <div id="editAuctionButton"><a href="/auctionEdit/{{$auction->id}}"><button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 edit">Edit Auction</button></a></div>
                    <div id="editAuctionButton"><a href="/auctionStatus/{{$auction->id}}"><button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 edit">Change Status</button></a></div>
                    @if ((!$auction->hasBids($auction->id) || $auction->onlyBidsDel($auction->id)))
                        <div id="editAuctionButton">
                        <form action="/auctionCancel" method="POST" id="auctionCancel" class="profile" >
                        {{ csrf_field() }}
                        <input type="hidden" name="auction" value="{{ $auction->id }}">
                            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="Submit">Cancel Auction</button>
                        </form>    
                        </div> <br>
                    @endif
                @elseif (auth()->check())
                    @if ($auction->isAuct(auth()->user()->id))
                        @if ($auction->isOwner(auth()->user()->id,$auction->id))
                            <div id="editAuctionButton"><a href="/auctionEdit/{{$auction->id}}"><button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 edit">Edit Auction</button></a></div>
                            <div id="editAuctionButton"><a href="/auctionStatus/{{$auction->id}}"><button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 edit">Change Status</button></a></div>
                            @if ((!$auction->hasBids($auction->id) || $auction->onlyBidsDel($auction->id)))
                                <div id="editAuctionButton">
                                <form action="/auctionCancel" method="POST" id="auctionCancel" class="profile" >
                                {{ csrf_field() }}
                                <input type="hidden" name="auction" value="{{ $auction->id }}">
                                    <button type="Submit" id="buttonInvBack" class="btn btn-outline-light btn-lg px-5">Cancel Auction</button>
                                </form>    
                                </div> <br>
                            @endif
                        @else
                          @if (!$auction->isFollowed($auction->id,auth()->user()->id))
                          <div id="editAuctionButton">
                          <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                          <form target="dummyframe" method="POST" id="auctionFollow" class="profile" >
                          {{ csrf_field() }}
                          <input id="formAuction" type="hidden" name="auction" value="{{ $auction->id }}">
                          <input id="formUser" type="hidden" name="user" value="{{ auth()->user()->id }}">
                              <button type="Submit" id="buttonInvBack" class="btn btn-outline-light btn-lg px-5">Follow Auction</button>
                          </form>    
                          </div> <br>
                          @else
                          <div id="editAuctionButton">
                          <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                          <form target="dummyframe" method="POST" id="auctionUnFollow" class="profile" >
                          {{ csrf_field() }}
                          <input id="formAuction" type="hidden" name="auction" value="{{ $auction->id }}">
                          <input id="formUser" type="hidden" name="user" value="{{ auth()->user()->id }}">
                              <button type="Submit" id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 following">Following</button>
                          </form>    
                          </div> <br>
                          @endif   
                        @endif
                    @else
                      @if (!$auction->isFollowed($auction->id,auth()->user()->id))
                      <div id="editAuctionButton">
                        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                        <form target="dummyframe" method="POST" id="auctionFollow" class="profile" >
                        {{ csrf_field() }}
                        <input id="formAuction" type="hidden" name="auction" value="{{ $auction->id }}">
                        <input id="formUser" type="hidden" name="user" value="{{ auth()->user()->id }}">
                            <button type="Submit" id="buttonInvBack" class="btn btn-outline-light btn-lg px-5 following">Follow Auction</button>
                        </form>    
                        </div> <br>
                      @else
                      <div id="editAuctionButton">
                          <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                          <form target="dummyframe" method="POST" id="auctionUnFollow" class="profile" >
                          {{ csrf_field() }}
                          <input id="formAuction" type="hidden" name="auction" value="{{ $auction->id }}">
                          <input id="formUser" type="hidden" name="user" value="{{ auth()->user()->id }}">
                              <button type="Submit" id="buttonInvBack" class="btn btn-outline-light btn-lg px-5">Following</button>
                          </form>    
                          </div> <br>

                      @endif
                    @endif
                @else
                @endif 
                </li>
                @else
                <li style="font-size: larger;"><strong>Closed</strong></li>
                <li style="font-size: larger;"><strong>Final Price</strong><text id="currentPriceText">: {{$auction->pricenow}} €</text></li>
                @endif
                
                
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>Descritpion</h2>
              <p>
              {{$auction->descriptions}}
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

<!-- Table -->
<section id="portfolio-details" class="portfolio-details" style="padding-bottom: 9.1%;">
  <div class="content">
    <div class="container">
    <div class="row gy-4">

        <div class="col-lg-8">
        <h2 class="mb-5 bidsTableTitle">Top 5 bids</h2>
        <div class="table-responsive">

            <table id="tables" class="table custom-table">
            <thead>
                <tr>
                
                <th id="bids?" scope="col">Bid</th>
                <th scope="col">Value</th>
                <th scope="col">User</th>
                </tr>
            </thead>
            <tbody>
            @if ($auction->getTopBid($auction->id)->toArray() != [])
            @foreach ($auction->getTopBids($auction->id) as $i=>$bid)
                @include('partials.bids', [$bid,$i])
                @endforeach
            @else
                <tr><td></td><td>No Bids Yet</td><td></td></tr>
            @endif    

                
            </tbody>
            </table>
        </div>
        </div>
        @if ($auction->states != 'Closed')
        @if (Auth::check() && Auth::user()->id != $auction->getUser($auction->owners)->id)
        <div class="col-lg-4">
            <div class="portfolio-info bidFormBox">
              <h3>Make Bid</h3>
              <ul>
                <li><iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                        <form id='BidForm' target="dummyframe" onsubmit="return checkBidValue()">
                    

                        <label class="form-label" for="bid">Bid Amount €</label>
  

                        <input id="bidInput" type="text" class="form-control form-control-lg" onkeypress="return checkNumber(event)" name="bid" value="{{ floor($auction->pricenow * 1.05) +1}}" required>
                        <label id="error"></label><br>
                        <input type="hidden" id="formAuction" name="auction" value="{{ $auction->id }}">
                        <input type="hidden" id="formUser" name="user" value="{{ Auth::user()->id }}">

                        <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="button" onclick="return checkBidValue()">
                            Make Bid
                        </button>
                        <div id="bidConfirm">
                        <p>Are you Sure?</p>
                        <button id="finalBidButton" class="btn btn-outline-light btn-lg px-5" type="button">
                            Yes
                        </button>
                        <button id="buttonInvBack" type="button" class="btn btn-outline-light btn-lg px-5" onclick="return closeBidConfirm()">
                            No
                        </button>
                        </div>
                        
                    </form>
                </li>
              </ul>
            </div>
          </div>
        @endif
        @endif



    </div>
    </div>
  </div>
  </section>

  <!-- End Table -->

@php
$time = strtotime($auction->toArray()['timeclose']);
@endphp

@if ($auction->states != 'Closed')
<script src="{{ asset('js/clock.js') }}" defer onload="startTime();"> </script>
<p hidden id = "startValue">{{ floor($auction->pricenow * 1.05) }}</p>
<p id="HighestBidder" hidden>{{$auction->highestbidder}}</p>

<p hidden id = "hTime"><?php echo $time; ?></p>
@endif