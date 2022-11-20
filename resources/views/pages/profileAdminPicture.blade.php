@extends('layouts.app')

@section('name', $admin->names)

@section('content')
    @include('partials.profileAdminPicture', ['admin' => $admin])
@endsection