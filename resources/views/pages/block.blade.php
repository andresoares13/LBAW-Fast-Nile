@extends('layouts.app')

@section('name', $user->names)

@section('content')
    @include('partials.block', ['user' => $user])
@endsection