@extends('layouts.app')

@section('name', $admin->names)

@section('content')
  @include('partials.profileAdminEdit', ['admin' => $admin])

@endsection