@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section id="cards">
  @each('partials.auction', $auctions, 'auction')
</section>

@endsection
