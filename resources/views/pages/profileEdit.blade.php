@extends('layouts.app')

@section('name', $user->names)

@section('content')
  @include('partials.profileEdit', ['user' => $user])
@endsection