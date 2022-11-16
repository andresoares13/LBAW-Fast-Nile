@extends('layouts.app')

@section('title', $auction->title)

@section('content')
  @include('partials.auctionPage', ['auction' => $auction])
@endsection


