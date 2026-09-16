@extends('layouts.admin')
@section('title', 'Edit Sponsor')
@section('content')
@include('admin.sponsors.form', ['title' => 'Edit Sponsor', 'formAction' => route('admin.sponsors.update', $sponsor), 'method' => 'PUT', 'sponsor' => $sponsor])
@endsection
