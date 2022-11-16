<article class="card" data-id="{{ $auction->id }}">
<header>
  <h1 id='AuctionTitle' ><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h1>
</header>
<img class= "AuctionsPic" src= "{{asset('img/car/' . $auction->getCarPicture($auction->id))}}" /> 
@if ($auction->getTopBid($auction->id)->toArray() == [])
<table id="tables">  
    <caption id='BidsTable' >Top Bids</caption>
    <th>No Bids yet</th>
</table>
@else
<table id="tables">  
    <caption id='BidsTable' >Top Bids</caption>
    <tr><th scope="col">Bid</th><th scope="col">Value</th><th scope="col">User</th></tr>
    @foreach ($auction->getTop10Bids($auction->id) as $bid)
        @include('partials.bids', $bid)
    @endforeach
</table>

@endif

<form id='BidForm' method="POST" action="{{ route('login') }}">
    <caption id='BidForm' >Closes in: </caption>

    {{ csrf_field() }}

    <label for="bid">Bid Amount</label>
    <script src="{{ asset('js/pages.js') }}"></script>

    <input id="bid" type="text" onkeypress="return checkNumber(event)" name="bid" value="{{ floor($auction->pricenow * 1.05) }}" required autofocus>

    <button type="submit" onclick="return checkBidValue(event,value)">
        Make Bid
    </button>
</form>

</article>