@extends('layouts.app')

@section('title', 'Home')

@section('content')


@if (isset($category))
@else
@php
$category = 'Category';
@endphp
@endif

        <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          @if (count($auctions)==0)
            @if (isset($follow))
            <h1 style="font-weight: bold;">No followed auctions found at this time</h1>
            @else
              <h1 style="font-weight: bold;">There are no auctions at this time</h1>
            @endif
          @else
            @if (isset($id))
              @if (isset($follow))
              
              @else
                @if (auth()->check())
                  @if (auth()->user()->id == $userId)
                    <h1 style="font-weight: bold;">My Auctions Page {{$pageNr}}</a></h1>
                  @else
                    <h1 style="font-weight: bold;">{{$name}} Auctions Page {{$pageNr}}</h1>
                  @endif
                @else
                  <h1 style="font-weight: bold;">{{$name}} Auctions Page {{$pageNr}}</h1>
                @endif
              @endif  
            @else
              @if (!isset($follow))
              <h1 style="font-weight: bold;">Auctions Page {{$pageNr}}</h1>
              @else
              <h1 style="font-weight: bold;">Followed Auctions Page {{$pageNr}}</h1>
              @endif
            @endif
            
          @endif
          <form id="searchForms" class="d-flex"  action="/auctions/{{$pageNr}}"  method="get" role="search" >
              <select  class="form-select" id="categorie" name='category' onchange="this.form.submit()" required>
              <option value="" selected>{{$category}}</option>
                <option value="Sport">Sport</option>
                <option value="Coupe">Coupe</option>
                <option value="Convertible">Convertible</option>
                <option value="SUV">SUV</option>
                <option value="Pickup Truck">Pickup Truck</option>
              </select>
            </form>
            
        </div>
        @if ($category!="Category")
            <h1 style="font-weight: bold;" class="d-flex" style="margin-left:auto;">Category: {{$category}}</h1>
            @endif
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

      @if (count($auctions)!=0 && $totalPages > 1)
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
      @endif

</section>


    


@endsection