@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Роль</h4>
    {{$role->name}}

    {{ Form::open(['route'=> ['role.destroy', $role->slug], 'method'=>'delete']) }}
    {{ Form::submit('Удалить') }}
    {{ Form::close() }}
@endsection
