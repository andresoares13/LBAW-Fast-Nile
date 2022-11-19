@extends('layouts.app')

@section('title', 'Home')

@section('content')
<link href="{{ asset('css/userCards.css') }}" rel="stylesheet">
        <p id="pagePara">
          Users Page {{$pageNr}} 
          
        </p>
        <p>
        <form id="formSearch" action="/search/user"  method="get" role="search">
          <input type="search" id="query" name="q"
          placeholder="Search for a user..."
          aria-label="Search through site content">
          <button type='submit'>
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        </form>
        </p>


        <br>
    <section id="auctionAll">    
        <ul>
        <br>
        @each('partials.userCard', $users, 'user')
        <p id="pageLinks">
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <a href="/users/{{$i+1}}">{{$i+1}}</a>
        @endif
        @endfor
        </p>
        </ul>

    </section>

    


@endsection