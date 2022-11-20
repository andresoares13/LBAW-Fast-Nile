@extends('layouts.app')

@section('name', $admin->names)

@section('content')
  @include('partials.profileAdmin', ['admin' => $admin])

@endsection