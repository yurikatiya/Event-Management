@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
	@include('admin.categories.partials.form', ['title' => 'Edit Category', 'subtitle' => 'Perbarui informasi kategori event.', 'formAction' => route('admin.categories.update', $category), 'method' => 'PUT', 'category' => $category])
@endsection