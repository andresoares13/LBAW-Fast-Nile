@extends('layouts.app')

@section('name', $auction->id)

@section('content')
  @include('partials.auctionStatus', ['auction' => $auction])
@endsection