@extends('layouts.admin')
@section('pageTitle', 'Новый пользователь')
@section('pageSubTitle', '')
@section('content')
    @include('admin.users.edit_form')
@endsection
