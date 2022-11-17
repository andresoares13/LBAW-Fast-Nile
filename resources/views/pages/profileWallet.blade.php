@extends('layouts.app')

@section('name', $user->names)

@section('content')
  @include('partials.profileWallet', ['user' => $user])
@endsection