@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Пермишен</h4>
    {{$permission->name}}

    {{ Form::open(['route'=> ['permission.destroy', $permission->id], 'method'=>'delete']) }}
    {{ Form::submit('Удалить') }}
    {{ Form::close() }}
@endsection
