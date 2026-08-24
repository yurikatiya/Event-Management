@extends('layouts.admin')
@section('title', 'Add Partner')
@section('content')
@include('admin.partners.form', ['title' => 'Add Partner', 'formAction' => route('admin.partners.store'), 'method' => 'POST', 'partner' => null])
@endsection