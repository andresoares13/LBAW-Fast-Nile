

<article class="card" data-id="{{ $auction->id }}">
<header>
  <h2><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h2>
  <a href="/auction/{{ $auction->id }}"><img class= "mainAuctionsPic" src= "{{asset('img/car/' . $auction->getCarPicture($auction->id))}}" /></a>
</header>
<ul>
  <li>Owner: <a href="/profile/{{$auction->getUser($auction->owners)->id}}">{{$auction->getAuctioneerName($auction->owners)}}</a></li>
  @each('partials.bid', $auction->getTopBid($auction->id), 'bid')
  @if (count($auction->getTopBid($auction->id))==0)
  <li>No bids  | Starting price: {{$auction->pricestart}} €</li>
  @endif
</ul>
</article>
