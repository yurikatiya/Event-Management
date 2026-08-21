@extends('layouts.admin')
@section('title', 'Add Event')
@section('content')
	@include('admin.events.form', ['title' => 'Add Event', 'subtitle' => 'Tambahkan event baru ke website publik.', 'formAction' => route('admin.events.store'), 'method' => 'POST', 'event' => null])
@endsection