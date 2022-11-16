

<article class="card" data-id="{{ $auction->id }}">
<header>
  <h2><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h2>
  <a href="/auction/{{ $auction->id }}"><img class= "mainAuctionsPic" src= "{{asset('img/car/' . $auction->getCarPicture($auction->id))}}" /></a>
</header>
<ul>
  @each('partials.bid', $auction->getTopBid($auction->id), 'bid')
</ul>
</article>
