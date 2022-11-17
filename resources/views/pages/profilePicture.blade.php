@extends('layouts.app')

@section('name', $user->names)

@section('content')
  @include('partials.profilePicture', ['user' => $user])
@endsection