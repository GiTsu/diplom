@extends('layouts.admin')
@section('pageTitle', 'Редактировать вопрос')
@section('pageSubTitle', '')
@section('content')
   @include('admin.questions.edit_form')
@endsection
