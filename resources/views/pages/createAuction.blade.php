@extends('layouts.app')

@section('name', $user->names)

@section('content')
  @include('partials.createAuction', ['user' => $user,'auctioneer' => $auctioneer])
@endsection