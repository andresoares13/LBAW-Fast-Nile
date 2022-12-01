@extends('layouts.app')

@section('name', 'home')

@section('content')
        @if ($auctions != [])
        @include('partials.home',[$auctions,$soonAuction])
        @else
        @include('partials.homeFail')
  @endif
@endsection





