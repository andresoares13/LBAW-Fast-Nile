@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        @if (Auth::guard('admin')->check())
          <h1 style="font-weight: bold;">{{$name}} Bid History</h1>
        @else
        <h1 style="font-weight: bold;">My Bid History</h1>
        @endif
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section style="min-height: calc(100vh - 238px);">
    <div class="table-responsive">
        <table id="tables" class="table custom-table" style="text-align: center;margin-top:60px;margin-left:auto;margin-right:auto;">
        <thead>
            <tr>         
            <th id="bids?" scope="col">Bid</th>
            <th scope="col">Value</th>
            <th scope="col">Auction</th>
            </tr>
        </thead>
        <tbody>
        @if (count($bids)!=0)
         @foreach ($bids as $i=>$bid)
              @include('partials.bids', [$bid,$i,$pageNr])
          @endforeach
        @else
            <tr><td></td><td>No Bids Yet</td><td></td></tr>
        @endif    
        </tbody>
        </table>
    </div>
        @if (count($bids)!=0)
        <p id="pageLinks">
        <div class="bg pageNum">
        <ul class="pagination">
        @if ($pageNr == 1)
        <li class="page-item disabled">
          <a class="page-link" href="#">&laquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/profile/bids/{{$id}}/{{$pageNr-1}}">&laquo;</a>
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <li class="page-item ">
        <a class="page-link" href="/profile/bids/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        </li>
        @endif
        @endfor
        @if ($totalPages == $pageNr)
        <li class="page-item disabled">
          <a class="page-link" href="#">&raquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/profile/bids/{{$id}}/{{$pageNr+1}}">&raquo;</a>
        </li>
        @endif
        </ul>
        </div>
        </p>
        @endif
</section>    




@endsection