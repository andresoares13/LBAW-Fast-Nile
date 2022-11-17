<article class="card" data-id="{{ $auction->id }}">
<header>
  <h1 id='AuctionTitle' ><a href="/auction/{{ $auction->id }}">{{ $auction->title }}</a></h1>
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

<form id='BidForm' method="POST" action="/bid" onsubmit="return checkBidValue()">
    <p id='clock'>Closes in: </p>

    {{ csrf_field() }}
   

    <label for="bid">Bid Amount</label>
    <script src="{{ asset('js/pages.js') }}"></script>

    <input id="bidInput" type="text" onkeypress="return checkNumber(event)" name="bid" value="{{ floor($auction->pricenow * 1.05) +1}}" required autofocus>
    <input type="hidden" name="auction" value="{{ $auction->id }}">
    <input type="hidden" name="user" value="{{ Auth::user()->id }}">

    

    <button type="submit" >
        Make Bid
    </button>
    
</form>
<p hidden id = "hTime"><?php echo $time; ?></p>
<body onload="startTime()"> </body>

</article>