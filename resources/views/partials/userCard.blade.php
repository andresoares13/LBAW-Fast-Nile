
<div class="col-xs-12 col-sm-6 col-md-4">
  <div class="image-flip" >
      <div class="mainflip flip-0">
      <a href="{{ url('/profile/'. $user->id) }}">
          <div class="frontside">
              <div class="card">
                  <div class="card-body text-center">
                      <p><img class="img-fluid" src="{{asset('img/profile/' . $user->picture)}}" alt="card image"></p>
                      <h4 class="card-title"><strong>{{$user->names}}</strong></h4>
                      <h4 class="card-title">
                      @if ($user->isAuctioneer($user->id))
                      Auctioneer
                      @else
                      User
                      @endif
                      </h4>
                      
                  </div>
              </div>
          </div>
          <div class="backside">
              <div class="card">
                  <div class="card-body text-center mt-4">
                  <h4 class="card-title"><strong>{{$user->names}}</strong></h4>
                      <p class="card-text">This user has won {{count($user->getAuctionsWon($user->id))}} auction(s), and has made {{count($user->getBidsMade($user->id))}} bids</p>
                      <p class="card-text">Address: {{$user->address}}</p>
                      @if ($user->isAuctioneer($user->id))
                      <p class="card-text">Phone Number: {{$user->getAuctioneer($user->id)[0]['phone']}}</p>
                      @endif
                  </div>
              </div>
          </div>
          </a>
      </div>
  </div>
</div>


