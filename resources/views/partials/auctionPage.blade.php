<article class="card" data-id="{{ $auction->id }}">
<header>
  <h1 id='AuctionTitle' ><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h1>
  @if (auth()->guard('admin')->check())
  <div id="editAuctionButton"><a href="/auctionEdit/{{$auction->id}}"><button>Edit Auction</button></a></div>
  @elseif (auth()->check())
    @if ($auction->isOwner(auth()->user()->id,$auction->id))
    <div id="editAuctionButton"><a href="/auctionEdit/{{$auction->id}}"><button>Edit Auction</button></a></div>
    @if (!$auction->hasBids($auction->id))
    <div id="editAuctionButton">
    <form action="/auctionCancel" method="POST" id="auctionCancel" class="profile" >
    {{ csrf_field() }}
    <input type="hidden" name="auction" value="{{ $auction->id }}">
        <button type="Submit">Cancel Auction</button>
    </form>    
    </div> <br>
    @endif
    @endif
  @else
  @endif  
</header>

@php
$time = strtotime($auction->toArray()['timeclose']);
@endphp
<script src="{{ asset('js/clock.js') }}" defer> </script>
<p hidden id = "startValue">{{ floor($auction->pricenow * 1.05) }}</p>

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
    @foreach ($auction->getTop10Bids($auction->id) as $i=>$bid)
        @include('partials.bids', [$bid,$i])
    @endforeach
</table>

@endif

<article id="currentPrice">
    <p>Current price: {{ floor($auction->pricenow ) }}</p>
    <p id='clock'>Closes in: </p> 
</article>


@if (Auth::check()){
    <form id='BidForm' method="POST" action="/bid" onsubmit="return checkBidValue()">
   

    {{ csrf_field() }}
   

    <label for="bid">Bid Amount €</label>
    <script src="{{ asset('js/pages.js') }}"></script>

    <input id="bidInput" type="text" onkeypress="return checkNumber(event)" name="bid" value="{{ floor($auction->pricenow * 1.05) +1}}" required autofocus>
    <label id="error"></label>
    <input type="hidden" name="auction" value="{{ $auction->id }}">
    <input type="hidden" name="user" value="{{ Auth::user()->id }}">

    

    <button type="submit" onclick="return checkBidValue()">
        Make Bid
    </button>
    
</form>
}

@endif

<p hidden id = "hTime"><?php echo $time; ?></p>
<body onload="startTime()"> </body>

</article>