@extends('layouts.app')

@section('title', 'Home')

@section('content')

        <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Users Page: {{$pageNr}}</h1>
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
        <p id="pageLinks">
        <div class="bg pageNum">
        <ul class="pagination">
        @if ($pageNr == 1)
        <li class="page-item disabled">
          <a class="page-link" href="#">&laquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/users/{{$pageNr-1}}">&laquo;</a>
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <li class="page-item ">
        <a class="page-link" href="/users/{{$i+1}}">{{$i+1}}</a>
        </li>
        @endif
        @endfor
        @if ($totalPages == $pageNr)
        <li class="page-item disabled">
          <a class="page-link" href="#">&raquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/users/{{$pageNr+1}}">&raquo;</a>
        </li>
        @endif
        </ul>
        </div>
        </p>
        </section>
 





@endsection