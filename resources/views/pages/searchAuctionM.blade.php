@extends('layouts.app')

@section('title', 'Home')

@section('content')
        @if (count($auctions)!=0)
        <p id="pagePara">
          Auctions containing: "{{$query}}" (Exact Match)
        </p>

        <p>
        <form id="formSearch" action="/search/auctionM"  method="get" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search for an Auction..."
          aria-label="Search through site content">
          <button type='submit'>
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        </form>
        </p>
        @else
        <p id="pagePara">
          There are no auctions containing exactly: "{{$query}}"
        </p>
        <p>
        <form id="formSearch" class="None" action="/search/auctionM"  method="get" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search for an Auction..."
          aria-label="Search through site content" >
          <button type='submit'>
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        </form
        @endif

      
<section id="auctionAll">
  <ul>
  @each('partials.auction', $auctions, 'auction')
  </ul>
</section>

@endsection