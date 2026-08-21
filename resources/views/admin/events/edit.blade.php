@extends('layouts.admin')
@section('title', 'Edit Event')
@section('content')
	@include('admin.events.form', ['title' => 'Edit Event', 'subtitle' => 'Perbarui informasi event.', 'formAction' => route('admin.events.update', $event), 'method' => 'PUT', 'event' => $event])
@endsection