<article class="card" data-id="{{ $auction->id }}">
<header>
  <h1 id='AuctionTitle' ><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h1>
  @if (auth()->guard('admin')->check())
  <div id="editAuctionButton"><a href="/auctionEdit/{{$auction->id}}"><button>Edit Auction</button></a></div>
  @elseif (auth()->check())
    @if ($auction->isAuct(auth()->user()->id))
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
    <th id="bids?">No Bids yet</th>
</table>
@else
<table id="tables">  
    <caption id='BidsTable' >Top Bids</caption>
    <tr><th id="bids?" scope="col">Bid</th><th scope="col">Value</th><th scope="col">User</th></tr>
    @foreach ($auction->getTop10Bids($auction->id) as $i=>$bid)
        @include('partials.bids', [$bid,$i])
    @endforeach
</table>

@endif

<article id="currentPrice">
<p >Owner: <a href="/profile/{{$auction->getUser($auction->owners)->id}}">{{$auction->getAuctioneerName($auction->owners)}}</a></p> 

<p id="HighestBidder" hidden>{{$auction->highestbidder}}</p>

    <p id="currentPriceText">Current price: {{ floor($auction->pricenow ) }}</p>
    <p id='clock'>Closes in: </p> 
    <br>
    
</article>


@if (Auth::check() && Auth::user()->id != $auction->getUser($auction->owners)->id)
<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
    <form id='BidForm' target="dummyframe" onsubmit="return checkBidValue()">
   

    <label for="bid">Bid Amount €</label>
    <script src="{{ asset('js/pages.js') }}"></script>

    <input id="bidInput" type="text" onkeypress="return checkNumber(event)" name="bid" value="{{ floor($auction->pricenow * 1.05) +1}}" required autofocus>
    <label id="error"></label>
    <input type="hidden" id="formAuction" name="auction" value="{{ $auction->id }}">
    <input type="hidden" id="formUser" name="user" value="{{ Auth::user()->id }}">

    

    <button id="bidButton" type="button" onclick="return checkBidValue()">
        Make Bid
    </button>
    <div id="bidConfirm">
    <p>Are you Sure?</p>
    <button id="finalBidButton" type="button">
        Yes
    </button>
    <button type="button" onclick="return closeBidConfirm()">
        No
    </button>
    </div>
    
</form>


@endif

<article id="descriptionA"> 
    <h2>Descritpion</h2>
    <p>{{$auction->descriptions}}</p>
</article>

<p hidden id = "hTime"><?php echo $time; ?></p>
<body onload="startTime();addEventListeners();"> </body>

</article>