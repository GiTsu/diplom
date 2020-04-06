@extends('layouts.admin')
@section('pageTitle', 'Новый вопрос')
@section('pageSubTitle', '')
@section('content')
    @include('admin.admin.questionItems.create_form')
@endsection
