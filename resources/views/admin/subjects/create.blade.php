@extends('layouts.admin')
@section('pageTitle', 'Новый предмет')
@section('pageSubTitle', '')
@section('content')
   @include('admin.subjects.create_form')
@endsection
