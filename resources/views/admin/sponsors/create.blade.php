@extends('layouts.admin')
@section('title', 'Add Sponsor')
@section('content')
@include('admin.sponsors.form', ['title' => 'Add Sponsor', 'formAction' => route('admin.sponsors.store'), 'method' => 'POST', 'sponsor' => null])
@endsection
