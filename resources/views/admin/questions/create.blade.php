@extends('layouts.admin')
@section('pageTitle', 'Новый вопрос')
@section('pageSubTitle', '')
@section('content')
   @include('admin.questions.create_form')
@endsection
