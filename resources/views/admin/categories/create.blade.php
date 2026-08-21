@extends('layouts.admin')
@section('title', 'Add Category')
@section('content')
	@include('admin.categories.partials.form', ['title' => 'Add Category', 'subtitle' => 'Buat kategori baru untuk mengelompokkan event.', 'formAction' => route('admin.categories.store'), 'method' => 'POST', 'category' => null])
@endsection