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