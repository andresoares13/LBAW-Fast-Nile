
<a href="{{ url('/profile/'. $user->id) }}">
<div class="center">
  <div class="userCard">
    <div class="additional">
      <div class="user-card">
        <img id="userImg" src="{{asset('img/profile/' . $user->picture)}}" alt="ProfilePic">
        <div id="userType">
        @if ($user->isAuctioneer($user->id))
        <p>Auctioneer</p>
        @else
        <p>User</p>
        @endif
        </div>
      </div>
      <div class="more-info">
        <h1>{{$user->names}}</h1>
        <br>
        <div class="coords">
          <span>Address</span>
          <span>{{$user->address}}</span>
        </div>
        @if ($user->isAuctioneer($user->id))
        <div class="coords">
          <span>Phone</span>
          <span>{{$user->getAuctioneer($user->id)[0]['phone']}}</span>
        </div>
        @endif
        <div class="stats">
          <div>
            <div class="title">Auctions Won</div>
            <i class="fa fa-group"></i>
            <div class="value">{{count($user->getAuctionsWon($user->id))}}</div>
          </div>
          <div>
            <div class="title">Bids made</div>
            <i class="fa fa-coffee"></i>
            <div class="value">{{count($user->getBidsMade($user->id))}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="general">
      <h1>{{$user->names}}</h1>
      <p></p>
      <span class="more">Mouse over the card for more info</span>
    </div>
  </div>

</div>
</a>
<br><br>