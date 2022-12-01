@extends('layouts.app')

@section('title', $auction->title)

@section('content')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  @include('partials.auctionPage', ['auction' => $auction])
@endsection


