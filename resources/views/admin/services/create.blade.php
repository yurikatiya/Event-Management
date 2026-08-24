@extends('layouts.admin')
@section('title', 'Add Service')
@section('content')
@include('admin.services.form', ['title' => 'Add Service', 'formAction' => route('admin.services.store'), 'method' => 'POST', 'service' => null])
@endsection