@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/auctionsPagesFilters.js') }}" defer> </script>

@if (isset($filter))
<p hidden id="filter"></p>
@endif

@if (isset($category))
<p hidden id="categoryFilter">{{$category}}</p>
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
          <form id="searchForms" class="d-flex"  action="/search/auction"  method="get" role="search">
        <input class="form-control me-sm-2" type="search" placeholder="Search for an Auction..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
        <div class="d-flex justify-content-between align-items-center" style="margin-top: 2%;">
        <form id="categoriesForm" class="d-flex"  action="{{Request::getRequestUri()}}"  method="get" role="search" >
              <select class="form-select" id="categories" name='category' onchange="updateForms('categories');this.form.submit()" required>
              <option value="">Category</option>
                <option id="Sport" value="Sport">Sport</option>
                <option id="Coupe" value="Coupe">Coupe</option>
                <option id="Convertible" value="Convertible">Convertible</option>
                <option id="SUV" value="SUV">SUV</option>
                <option id="PickupTruck" value="Pickup Truck">Pickup Truck</option>
              </select>
            </form>

            <form id="statesForm" class="d-flex"  action="{{Request::getRequestUri()}}"  method="get" role="search" >
              <select class="form-select" id="states" name='state' onchange="updateForms('states');" required>
              <option value="">Car States</option>
              <option value="Wreck">Wreck</option>
                <option value="Poor Condition">Poor Condition</option>
                <option value="Normal Condition">Normal Condition</option>
                <option value="High Condition">High Condition</option>
                <option value="Brand New">Brand New</option>
              </select>
            </form>

            <form id="searchForms" class="d-flex"  action="/auctions/{{$pageNr}}"  method="get" role="search" >
              <select class="form-select" id="" name='category' onchange="this.form.submit()" required>
              <option value="">Category</option>
                <option id="Sport" value="Sport">Sport</option>
                <option id="Coupe" value="Coupe">Coupe</option>
                <option id="Convertible" value="Convertible">Convertible</option>
                <option id="SUV" value="SUV">SUV</option>
                <option id="PickupTruck" value="Pickup Truck">Pickup Truck</option>
              </select>
            </form>

        </div>
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
          @if ($category!="Category")
          <a class="page-link" href="{{url('/auctions/'.($pageNr-1).'?category='.$category)}}">&laquo;</a>
          @else
          <a class="page-link" href="/auctions/{{$pageNr-1}}">&laquo;</a>
          @endif
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        @if (isset($id))
        <li class="page-item ">
        @if ($category!="Category")
          <a class="page-link" href="{{url('/profile/auctions/'.$id.'/'.($i+1).($pageNr-1).'?category='.$category)}}">{{$i+1}}</a>
          @else
        <a class="page-link" href="/profile/auctions/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        @endif
        </li>
        @else
        <li class="page-item ">
        @if ($category!="Category")
          <a class="page-link" href="{{url('/auctions/'.($i+1).'?category='.$category)}}">{{$i+1}}</a>
          @else
        <a class="page-link" href="/auctions/{{$i+1}}">{{$i+1}}</a>
        @endif
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