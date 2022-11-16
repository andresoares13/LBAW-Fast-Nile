@extends('layouts.app')

@section('name', $user->names)

@section('content')
  @php
  $auctioneer = $user->getAuctioneer($user->id);
  @endphp
  @if (count($auctioneer) == 0)
  @include('partials.profile', ['user' => $user])
  @else
  @include('partials.profile', ['user' => $user,'auctioneer' => $auctioneer])
  @endif
@endsection