@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/auctionsPagesFilters.js') }}" defer> </script>





@if (isset($category))
<p hidden id="categoryFilter">{{$category}}</p>
@else
@php
$category = 'Category';
@endphp
@endif

@if (isset($states))
<p hidden id="statesFilter">{{$states}}</p>
@else
@php
$states = 'State';
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

        @if (isset($filter))
        <div class="d-flex justify-content-between align-items-center" style="margin-top: 2%;">


          <div class="nav-item dropdown">
            @if ($category == "Category")
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >{{$category}}</a>
            @else
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >Category: {{$category}}</a>
            @endif
            <div class="dropdown-menu">
            @if ($states == "State")
            <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr) }}">All</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Sport') }}">Sport</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Coupe') }}">Coupe</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Convertible') }}">Convertible</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=SUV') }}">SUV</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Pickup Truck') }}">Pickup Truck</a>
            @else
            <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states='.$states) }}">All</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Sport&states='.$states) }}">Sport</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Coupe&states='.$states) }}">Coupe</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Convertible&states='.$states) }}">Convertible</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=SUV&states='.$states) }}">SUV</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category=Pickup Truck&states='.$states) }}">Pickup Truck</a>
              @endif
            </div>
          </div>


          <div class="nav-item dropdown">
            @if ($states == "State")
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >{{$states}}</a>
            @else
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >State: {{$states}}</a>
            @endif
            <div class="dropdown-menu">
            @if ($category == "Category")
            <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr) }}">All</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states=Wreck') }}">Wreck</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states=Poor Condition') }}">Poor Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states=Normal Condition') }}">Normal Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states=High Condition') }}">High Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?states=Brand New') }}">Brand New</a>
            @else
            <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category) }}">All</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category.'&states=Wreck') }}">Wreck</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category.'&states=Poor Condition') }}">Poor Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category.'&states=Normal Condition') }}">Normal Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category.'&states=High Condition') }}">High Condition</a>
              <a class="dropdown-item" href="{{ url('/auctions/'.$pageNr.'?category='.$category.'&states=Brand New') }}">Brand New</a>
            @endif
            </div>
          </div>
        
          

        </div>
        @endif
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