@extends('layouts.app')

@section('name', $auction->id)

@section('content')
  @include('partials.auctionEdit', ['auction' => $auction])
@endsection