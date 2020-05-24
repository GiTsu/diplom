@extends('layouts.admin')
@section('pageTitle', 'Новая группа')
@section('pageSubTitle', '')
@section('content')
    @include('admin.groups.create_form')
@endsection
