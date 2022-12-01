@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        @if (count($users)!=0)
          <h1 style="font-weight: bold;">Users similar to "{{$query}}" (Showing top {{count($users)}} results)</h1>
          @else
          <h1 style="font-weight: bold;">Found 0 matches for users similar to "{{$query}}" </h1> 
          @endif


        </div>
        <form id="searchForms" class="d-flex"  action="/search/user"  method="get" role="search">
        <input class="form-control me-sm-2" type="search" placeholder="Search for a user..." id="query" name="q">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

      </div>
    </section><!-- End Breadcrumbs -->


    <section style="min-height: calc(100vh - 276px);">    
    <div class="py-5">
    <div class="container">
      <div class="row hidden-md-up">
        @each('partials.userCard', $users, 'user')
        </div>
        </div>
        </div>

    </section>

    


@endsection