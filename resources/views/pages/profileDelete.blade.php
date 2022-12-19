@extends('layouts.app')

@section('name', $user->names)

@section('content')
    @include('partials.profileDelete', ['user' => $user])
@endsection