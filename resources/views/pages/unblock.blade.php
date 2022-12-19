@extends('layouts.app')

@section('name', $user->names)

@section('content')
    @include('partials.unblock', ['user' => $user,'block' => $block])
@endsection