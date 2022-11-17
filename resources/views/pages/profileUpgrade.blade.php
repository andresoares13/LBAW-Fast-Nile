@extends('layouts.app')

@section('name', $user->names)

@section('content')
    @include('partials.profileUpgrade', ['user' => $user])
@endsection