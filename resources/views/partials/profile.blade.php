

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          @if (auth()->check())
          @if (auth()->user()->id == substr(strrchr(url()->current(),"/"),1))
          <h1 style="font-weight: bold;">My Profile</h1>
          @else
          <h1 style="font-weight: bold;">User Profile: {{ $user->names }}</h1>
          @endif
          @else
          <h1 style="font-weight: bold;">User Profile: {{ $user->names }}</h1>
          @endif
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


<div class="col-xs-12 col-sm-6 col-md-4" style="margin-left: auto;margin-right:auto;margin-top:60px;margin-bottom:60px;min-height: calc(100vh - 358px);">
  <div class="frontside">
      <div class="card">
          <div class="card-body text-center">
              <p><img class=" img-fluid" src="{{asset('img/profile/' . $user->picture)}}" alt="card image"></p>
              <h4 class="card-title"><strong>{{$user->names}}</strong></h4>
              <h4 class="card-title">
              @if ($user->isAuctioneer($user->id))
              Auctioneer
              @else
              User
              @endif
              @if ($user->isBlocked($user->id))
              (Account Blocked)
              @endif
              </h4>
              <br>
              <p class="card-text">Address: {{$user->address}}
                @if ($user->address == "")
                undefined
                @endif
              </p>
                @if ($user->isAuctioneer($user->id))
                <p class="card-text">Phone Number: {{$user->getAuctioneer($user->id)[0]['phone']}}</p>
                @if ($user->getAuctioneer($user->id)[0]['grade'] != 0)
                <p class="card-text">Rating: {{$user->getAuctioneer($user->id)[0]['grade']}} <i class="fa-solid fa-star"></i></p>
                @else
                <p class="card-text">Rating: Unrated</p>
                @endif
                @if (!auth()->check() && !Auth::guard('admin')->check())
                <div id="profileOptions">
                <a href="{{ url('/profile/auctions/'. $auctioneer[0]['id'].'/1')}}">
                  <button id="buttonInvBack" style="margin-top: 0;margin-bottom: 10px;" class="btn btn-outline-light btn-lg px-5" type="button">{{$user->names}} auctions</button> 
                </a>
                  <a href="{{ url('/profile/following/'. $user->id . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Followed Auctions</button> 
                  </a>
                </div>
                @else
                  @if (!Auth::guard('admin')->check())
                  @if (auth()->user()->id != substr(strrchr(url()->current(),"/"),1) )
                  <div id="profileOptions">
                  @if (Session::get('info'))
                  <div class="alert alert-info">
                    {{Session::get('info')}}
                  </div>
                  @endif
                    <a href="{{ url('/profile/auctions/'. $auctioneer[0]['id'].'/1')}}">
                      <button id="buttonInvBack" style="margin-top: 0; margin-bottom: 10px" class="btn btn-outline-light btn-lg px-5" type="button">{{$user->names}} auctions</button> 
                    </a>
                    <a href="{{ url('/profile/following/'. $user->id . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Followed Auctions</button> 
                  </a>
                  @if($user->countRatingOnAuct(auth()->user()->id,$user->getAuctioneer($user->id)[0]['id'])<$user->countAuctionsWon(auth()->user()->id,$user->getAuctioneer($user->id)[0]['id']))
                        <a>
                          <p id="ratingtext" style="font-size:25px"> Rate this auctioneer</p>
                          <div id=starbuttons class="ratingstars">
                          <form action="/createRating" method="POST"> 

                          {{ csrf_field() }}
                              <input type="radio" name="ratingstars" value="5" id="5"><label for="5">☆</label>
                              <input type="radio" name="ratingstars" value="4" id="4"><label for="4">☆</label>
                              <input type="radio" name="ratingstars" value="3" id="3"><label for="3">☆</label>
                              <input type="radio" name="ratingstars" value="2" id="2"><label for="2">☆</label>
                              <input type="radio" name="ratingstars" value="1" id="1"><label for="1">☆</label>

                              <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                              <input type="hidden" name="auctioneer" value="{{ $user->getAuctioneer($user->id)[0]['id'] }}">
                              <input type="hidden" name="profile" value="{{ $user->id }}">

                              <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="submit">Rate</button> 
                          </form>
                          </div>
                        </a>
                      @endif  

                </div>
                  @endif
                  @endif  
                @endif
              @endif
              @if(Auth::guard('admin')->check())
              <div id="profileOptions">
              @if (Session::get('info'))
                  <div class="alert alert-info">
                    {{Session::get('info')}}
                  </div>
                  @endif
                @if ($user->isAuctioneer($user->id))
              <a href="{{ url('/profile/auctions/'. $auctioneer[0]['id'].'/1')}}">
                  <button id="buttonInvBack" style="margin-top: 0;margin-bottom: 10px;" class="btn btn-outline-light btn-lg px-5" type="button">{{$user->names}} auctions</button> 
                </a>
                @endif
                  <a href="{{ url('/profile/following/'. $user->id . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Followed Auctions</button> 
                  </a>
                <a href="{{ url('/profile/bids/'. strval($user->id) . '/1')}}">
                  <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">{{$user->names}} Bids</button> 
                </a>  
                <a href="{{ url('/profile/edit/'. substr(strrchr(url()->current(),"/"),1) )}}">
                  <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Edit Profile Information</button> 
                </a>
                <a href="{{ url('/profile/picture/'. substr(strrchr(url()->current(),"/"),1))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Change profile picture</button> 
                  </a>
                  @if ($user->isBlocked($user->id))
                  <a href="{{ url('/profile/unblock/'. substr(strrchr(url()->current(),"/"),1))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Unblock User</button> 
                  </a>
                  @else
                  <a href="{{ url('/profile/block/'. substr(strrchr(url()->current(),"/"),1))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Block User</button> 
                  </a>
                  @endif
                <a href="{{ url('/profile/delete/'. substr(strrchr(url()->current(),"/"),1))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Delete User</button> 
                  </a>
              </div>
              @endif
              @if (auth()->check())
                @if (auth()->user()->id == substr(strrchr(url()->current(),"/"),1))
                <div id="profileOptions">
                  @if (!$user->isAuctioneer($user->id))
                    <a href="{{ url('/profile/upgrade/'. strval(auth()->user()->id))}}">
                      <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Become an auctioneer</button> 
                    </a>
                  @else
                    <a href="{{ url('/profile/auctionCreate/'. strval(auth()->user()->id))}}">
                      <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Create an auction</button> 
                    </a>
                    <a href="{{ url('/profile/auctions/'. $auctioneer[0]['id'].'/1')}}">
                      <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">My Auctions</button> 
                    </a>
                  @endif
                  <a href="{{ url('/profile/bids/'. strval(auth()->user()->id) . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">My Bids</button> 
                  </a>
                  <a href="{{ url('/profile/following/'. strval(auth()->user()->id) . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Followed Auctions</button> 
                  </a>
                  <a href="{{ url('/profile/notifications/'. strval(auth()->user()->id) . '/1')}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Notifications</button> 
                  </a>
                  <a href="{{ url('/profile/edit/'. strval(auth()->user()->id))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Edit Profile Information</button> 
                  </a>
                  <a href="{{ url('/profile/wallet/'. strval(auth()->user()->id))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Add funds</button> 
                  </a>
                  <a href="{{ url('/profile/picture/'. strval(auth()->user()->id))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Change profile picture</button> 
                  </a>
                  <a href="{{ url('/profile/delete/'. strval(auth()->user()->id))}}">
                    <button id="buttonInvBack" style="margin-top: 0" class="btn btn-outline-light btn-lg px-5" type="button">Delete account</button> 
                  </a>
                @endif
              @endif    
              </div>  
          </div>
      </div>
  </div>
</div>    



