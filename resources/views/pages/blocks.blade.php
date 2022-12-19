@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        <h1 style="font-weight: bold;">Users Block List </h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section style="min-height: calc(100vh - 238px);">
    <div class="table-responsive">
        
        <table id="tables" class="table custom-table" style="text-align: center;margin-left:auto;margin-right:auto;min-width: 750px;">
        <thead>
            <tr>         
            <th id="bids?" scope="col">Block</th>
            <th scope="col">User</th>
            <th scope="col">By Admin</th>
            <th scope="col">justification</th>
            </tr>
        </thead>
        <tbody id="allNotifications">
        @if (count($blocks)!=0)
         @foreach ($blocks as $i=>$block)
              @include('partials.blocks', [$block,$i,$pageNr])
          @endforeach
        @else
            <tr><td></td><td>No Users Blocked</td><td></td></tr>
        @endif    
        </tbody>
        </table>
    </div>
        @if (count($blocks)!=0 && $totalPages > 1)
        <p id="pageLinks">
        <div class="bg pageNum">
        <ul class="pagination">
        @if ($pageNr == 1)
        <li class="page-item disabled">
          <a class="page-link" href="#">&laquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/users/blocked/{{$pageNr-1}}">&laquo;</a>
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <li class="page-item ">
        <a class="page-link" href="/users/blocked/{{$i+1}}">{{$i+1}}</a>
        </li>
        @endif
        @endfor
        @if ($totalPages == $pageNr)
        <li class="page-item disabled">
          <a class="page-link" href="#">&raquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/users/blocked/{{$pageNr+1}}">&raquo;</a>
        </li>
        @endif
        </ul>
        </div>
        </p>
        @endif
</section>    




@endsection