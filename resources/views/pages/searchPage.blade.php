@extends('layouts.app')

@section('title', 'Home')

@section('content')
        <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Search Page</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section style="min-height: calc(100vh - 318px);">

    
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container" style="text-align: center">

        <div class="justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Search for an Auction (Full text search)</h1>
        </div>
        <form id="searchForms" class="d-flex"  action="/search/auction"  method="get" role="search" style="justify-content: center; align-items: center;margin-left:auto;margin-right:auto;">
        <input class="form-control me-sm-2" type="search" placeholder="Search for an Auction..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

      </div>
    </section><!-- End Breadcrumbs -->


    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container" style="text-align: center"> 

        <div class=" justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Search for an Auction (Exact Match)</h1>
        </div>
        <form id="searchForms" class="d-flex"  action="/search/auctionM"  method="get" role="search" style="justify-content: center; align-items: center;margin-left:auto;margin-right:auto;">
        <input class="form-control me-sm-2" type="search" placeholder="Search for an Auction..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

      </div>
    </section><!-- End Breadcrumbs -->



    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container" style="text-align: center"> 

        <div class=" justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Browse auction by category</h1>
          <div class="d-flex categoriesBrowse" >
            <a class="category-icon" href="{{url('/auctions/1?category=Sport')}}"><img src="{{asset('img/icons/sport.png')}}" alt=""></a>
            <a class="category-icon" href="{{url('/auctions/1?category=Coupe')}}"><img src="{{asset('img/icons/Coupe.png')}}" alt=""></a>
            <a class="category-icon" href="{{url('/auctions/1?category=Convertible')}}"><img src="{{asset('img/icons/Convertible.png')}}" alt=""></a>
            <a class="category-icon" href="{{url('/auctions/1?category=SUV')}}"><img src="{{asset('img/icons/SUV.png')}}" alt=""></a>
            <a class="category-icon" href="{{url('/auctions/1?category=Pickup Truck')}}"><img src="{{asset('img/icons/PickupTruck.png')}}" alt=""></a>
            
          </div>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


    <section id="breadcrumbs" class="breadcrumbs" style="margin-bottom: 5%">
      <div class="container" style="text-align: center;">

        <div class="justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Search for a User by Name</h1>
        </div>
        <form id="searchForms" class="d-flex"  action="/search/user"  method="get" role="search" style="justify-content: center; align-items: center;margin-left:auto;margin-right:auto;">
        <input class="form-control me-sm-2" type="search" placeholder="Search for a User..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

      </div>
    </section><!-- End Breadcrumbs -->

    </section>


  
        


@endsection