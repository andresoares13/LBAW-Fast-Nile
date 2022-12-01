@extends('layouts.app')

@section('title', $auction->title)

@section('content')
  @include('partials.auction', ['auction' => $auction])
@endsection
