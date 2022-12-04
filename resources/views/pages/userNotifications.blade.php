@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        <h1 style="font-weight: bold;">My Notifications </h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section style="min-height: calc(100vh - 238px);">
    <div class="table-responsive">
        
        <table id="tables" class="table custom-table" style="text-align: center;margin-left:auto;margin-right:auto;min-width: 750px;">
        <caption id="markAllRead" style="caption-side: top;min-width:750px" class="table custom-table"> <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5"> Mark all as read <i class="fa-regular fa-eye"></i></button></caption>
        <thead>
            <tr>         
            <th id="bids?" scope="col">Notification</th>
            <th scope="col">Auction</th>
            <th scope="col">Message</th>
            </tr>
        </thead>
        <tbody id="allNotifications">
        @if (count($notifications)!=0)
         @foreach ($notifications as $i=>$notification)
              @include('partials.userNotifications', [$notification,$i,$pageNr])
          @endforeach
        @else
            <tr><td></td><td>No Notifications Yet</td><td></td></tr>
        @endif    
        </tbody>
        </table>
    </div>
        @if (count($notifications)!=0 && $totalPages > 1)
        <p id="pageLinks">
        <div class="bg pageNum">
        <ul class="pagination">
        @if ($pageNr == 1)
        <li class="page-item disabled">
          <a class="page-link" href="#">&laquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/profile/notifications/{{$id}}/{{$pageNr-1}}">&laquo;</a>
        </li>
        @endif
        @for ($i = 0; $i < $totalPages; $i++)
        @if ($pageNr != $i+1)
        <li class="page-item ">
        <a class="page-link" href="/profile/notifications/{{$id}}/{{$i+1}}">{{$i+1}}</a>
        </li>
        @endif
        @endfor
        @if ($totalPages == $pageNr)
        <li class="page-item disabled">
          <a class="page-link" href="#">&raquo;</a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link" href="/profile/notifications/{{$id}}/{{$pageNr+1}}">&raquo;</a>
        </li>
        @endif
        </ul>
        </div>
        </p>
        @endif
</section>    




@endsection