@extends('layouts.app')

@section('title', 'Home')

@section('content')
        <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          @if (count($auctions)==0)
          <h1 style="font-weight: bold;">There are no auctions at this time</h1>
          @else
          @if (isset($id))
          @if (auth()->check())
          @if (auth()->user()->id == $userId)
          <h1 style="font-weight: bold;">My Auctions Page {{$pageNr}}</a></h1>
          @else
          <h1 style="font-weight: bold;">{{$name}} Auctions Page {{$pageNr}}</h1>
          @endif
          @else
          <h1 style="font-weight: bold;">{{$name}} Auctions Page {{$pageNr}}</h1>
          @endif
          @else
          <h1 style="font-weight: bold;">Auctions Page {{$pageNr}}</h1>
          @endif
          @endif
        </div>
        <form id="searchForms" class="d-flex"  action="/search/auction"  method="get" role="search">
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


        <p id="pageLinks">
        <div class="bg pageNum">
        <ul class="pagination">
        @if ($pageNr == 1)
        <li class="page-item disabled">
          <a class="page-link" href="#">&laquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/auctions/{{$pageNr-1}}">&laquo;</a>
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        @if (isset($id))
        <li class="page-item ">
        <a class="page-link" href="/profile/auctions/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        </li>
        @else
        <li class="page-item ">
        <a class="page-link" href="/auctions/{{$i+1}}">{{$i+1}}</a>
        </li>
        @endif
        @endif
        @endfor
        @if ($totalPages == $pageNr)
        <li class="page-item disabled">
          <a class="page-link" href="#">&raquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/auctions/{{$pageNr+1}}">&raquo;</a>
        </li>
        @endif
        </ul>
        </div>
        </p>


</section>


    


@endsection