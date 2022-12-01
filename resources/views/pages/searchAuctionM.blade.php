@extends('layouts.app')

@section('title', 'Home')

@section('content')
        <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
      @if (count($auctions)!=0)
        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Auctions containing: "{{$query}}" (Full text search)</h1>
        </div>
        @else
        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">There are no auctions containing exactly: "{{$query}}"</h1>
        </div>
        @endif
        <form id="searchForms" class="d-flex"  action="/search/auctionM"  method="get" role="search" >
        <input class="form-control me-sm-2" type="search" placeholder="Search for an Auction..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

      </div>
    </section><!-- End Breadcrumbs -->
      
<section id="auctionAll">
<div class="py-5">
    <div class="container">
      <div class="row hidden-md-up">
  @each('partials.auction', $auctions, 'auction')
  </div>
  </div>
</div>
</section>

@endsection