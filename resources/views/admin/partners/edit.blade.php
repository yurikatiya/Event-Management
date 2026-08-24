@extends('layouts.admin')
@section('title', 'Edit Partner')
@section('content')
@include('admin.partners.form', ['title' => 'Edit Partner', 'formAction' => route('admin.partners.update', $partner), 'method' => 'PUT', 'partner' => $partner])
@endsection