@extends('layouts.admin')
@section('title', 'Edit Service')
@section('content')
@include('admin.services.form', ['title' => 'Edit Service', 'formAction' => route('admin.services.update', $service), 'method' => 'PUT', 'service' => $service])
@endsection