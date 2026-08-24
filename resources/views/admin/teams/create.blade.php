@extends('layouts.admin')
@section('title', 'Add Team Member')
@section('content')
@include('admin.teams.form', ['title' => 'Add Team Member', 'formAction' => route('admin.teams.store'), 'method' => 'POST', 'team' => null])
@endsection