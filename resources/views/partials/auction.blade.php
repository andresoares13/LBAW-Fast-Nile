
<div class="col-md-4">
<div id="auctionCard" class="card mb-3">
  <h3 class="card-header"><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h3>
  <div class="card-body navbar-dark">
    <h5 class="card-title">{{$auction->getCar($auction->idcar)->names}}</h5>
    <p class="card-text"><strong> Current Price</strong>: {{$auction->pricenow}} €
    <h6 class="card-subtitle text-muted">Owner: <a href="/profile/{{$auction->getUser($auction->owners)->id}}">{{$auction->getAuctioneerName($auction->owners)}}</a></h6>
  </div>
  <a href="/auction/{{ $auction->id }}">
  <img  src= "{{asset('img/car/' . $auction->getCarPicture($auction->idcar))}}" class="d-block user-select-none" width="100%" height="200" aria-label="Placeholder: Image cap" focusable="false" role="img" preserveAspectRatio="xMidYMid slice" viewBox="0 0 318 180" style="font-size:1.125rem;text-anchor:middle;padding: 3%;border-radius: 16px;">
    <rect width="100%" height="100%" fill="#868e96"></rect>
</img>
</a>
  <div class="card-body">
    @if (strlen($auction->descriptions) > 75)
    @php
    $stringCut = substr($auction->descriptions, 0, 75);
    @endphp
    @php
    $string = substr($stringCut, 0, strrpos($stringCut, ' '))."... ";
    @endphp
    <p class="card-text">{{ $string }}<a href="/auction/{{ $auction->id }}" title='view details'>Read More</a></p>
    @else
    <p class="card-text">{{ $auction->descriptions }}</p>
    @endif
  </div>
  <div class="card-footer ">
    @if (count($auction->getTopBid($auction->id))==0)
    No bids Yet
    @else
    {{$auction->getBidsNum($auction->id)}} Bids
    @endif
  </div>
</div>
</div>





