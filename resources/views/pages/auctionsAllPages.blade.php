@extends('layouts.app')

@section('title', 'Home')

@section('content')






@if (isset($category))
<p hidden id="categoryFilter">{{$category}}</p>
@else
@php
$category = 'Category';
@endphp
@endif

@if (isset($state))
<p hidden id="statesFilter">{{$state}}</p>

@else
@php
$state = 'Car State';
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
        <div class="d-flex justify-content-flex-start align-items-center" style="margin-top: 2%;">


          <div class="nav-item dropdown">
            @if ($category == "Category")
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >{{$category}}</a>
            @else
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >Category: {{$category}}</a>
            @endif
            <div class="dropdown-menu">
            @if ($state == "Car State")
            <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr }}">All</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Sport' }}">Sport</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Coupe' }}">Coupe</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Convertible' }}">Convertible</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=SUV' }}">SUV</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Pickup Truck' }}">Pickup Truck</a>
            @else
            <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states='.$state }}">All</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Sport&states='.$state }}">Sport</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Coupe&states='.$state }}">Coupe</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Convertible&states='.$state }}">Convertible</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=SUV&states='.$state }}">SUV</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category=Pickup Truck&states='.$state }}">Pickup Truck</a>
              @endif
            </div>
          </div>

          <div class="nav-item dropdown">
            @if ($state == "Car State")
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >{{$state}}</a>
            @else
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"  >Car State: {{$state}}</a>
            @endif
            <div class="dropdown-menu">
            @if ($category == "Category")
            <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr }}">All</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states=Wreck' }}">Wreck</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states=Poor Condition'}}">Poor Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states=Normal Condition' }}">Normal Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states=High Condition' }}">High Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?states=Brand New' }}">Brand New</a>
            @else
            <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category }}">All</a>
              <a class="dropdown-item" href="{{substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category.'&states=Wreck' }}">Wreck</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category.'&states=Poor Condition' }}">Poor Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category.'&states=Normal Condition' }}">Normal Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category.'&states=High Condition' }}">High Condition</a>
              <a class="dropdown-item" href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/')).'/'.$pageNr.'?category='.$category.'&states=Brand New' }}">Brand New</a>
            @endif
            </div>
          </div>
       
          @if (isset($all))
            @if ($filter)
            <a href="{{str_replace('allauctions', 'auctions', URL::full())}}" style="margin-left: auto;"><button class="btn btn-secondary my-2 my-sm-0" type="submit" style="margin-left: auto;">Show Only Active</button></a>
            @else
            <a href="{{url('/auctions/1')}}" style="margin-left: auto;"><button class="btn btn-secondary my-2 my-sm-0" type="submit" style="margin-left: auto;">Show Only Active</button></a>
            @endif
          
          @else
          
            @if ($filter)
            <a href="{{str_replace('auctions', 'allauctions', URL::full())}}" style="margin-left: auto;"><button class="btn btn-secondary my-2 my-sm-0" type="submit" style="margin-left: auto;">Also show Closed Auctions</button></a>
          
            @else
            <a href="{{url('/allauctions/1')}}" style="margin-left: auto;"><button class="btn btn-secondary my-2 my-sm-0" type="submit" style="margin-left: auto;">Also show Closed Auctions</button></a>
            @endif
          @endif
        
          

        </div>
        @endif
      </div>
    </section><!-- End Breadcrumbs -->



  
   

    <section id="auctionAll" style="min-height: calc(100vh - 238px);">
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
        <a class="page-link" href="{{str_replace($pageNr, $i+1, URL::full())}}">{{$i+1}}</a>
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