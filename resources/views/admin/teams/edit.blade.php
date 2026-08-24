@extends('layouts.admin')
@section('title', 'Edit Team Member')
@section('content')
@include('admin.teams.form', ['title' => 'Edit Team Member', 'formAction' => route('admin.teams.update', $team), 'method' => 'PUT', 'team' => $team])
@endsection