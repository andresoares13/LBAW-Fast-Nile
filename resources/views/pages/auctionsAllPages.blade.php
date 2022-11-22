@extends('layouts.app')

@section('title', 'Home')

@section('content')

        <p id="pagePara">
        @if (count($auctions)==0)
        There are no auctions at this time
        @else
        @if (isset($id))
        @if (auth()->check())
        @if (auth()->user()->id == $userId)
        My Auctions Page {{$pageNr}}
        @else
        {{$name}} Auctions Page {{$pageNr}}
        @endif
        @else
        {{$name}} Auctions Page {{$pageNr}}
        @endif
        @else
        Auctions Page {{$pageNr}}
        @endif 
        @endif
          <br>
        </p>
        <p>
        <form id="formSearch" action="/search/auction"  method="get" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search for an Auction..."
          aria-label="Search through site content">
          <button type='submit'>
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        </form>
        </p>


    <section id="auctionAll">    
        <ul>
        @each('partials.auction', $auctions, 'auction')
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
        </ul>

    </section>

    


@endsection