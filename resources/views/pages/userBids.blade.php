@extends('layouts.app')

@section('title', 'Home')

@section('content')

    @if (Auth::guard('admin')->check())
    <p id="pagePara">
        {{$name}} Bid History
    <br>
    </p>
    @else
    <p id="pagePara">
        My Bid History
    <br>
    </p>
    @endif


    <section id="myBids">    
        <table id="myBidsTable">  
          <tr><th scope="col">Bid</th><th scope="col">Value</th><th scope="col">Auction</th></tr>
          @foreach ($bids as $i=>$bid)
              @include('partials.bids', [$bid,$i,$pageNr])
          @endforeach
        </table>

        <p id="pageLinks">
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <a href="/profile/bids/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        @endif
        @endfor
        </p>




        <p id="pageLinks">
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        @if (isset($id))
        <a href="/profile/auctions/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        @else
        <a href="/auctions/{{$i+1}}">{{$i+1}}</a>
        @endif
        @endif
        @endfor
        </p>
   
    </section>

    


@endsection