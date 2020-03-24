@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Роли пользователей</h4>
    @if (!$roles->isEmpty())
        @foreach($roles as $role)
            <div class="row">
                <div class="w-25">
                    <a href="{{route('role.show', ['role'=>$role->slug])}}">{{$role->slug}}</a>
                </div>
                <div class="w-75">
                    <a href="{{route('role.edit', ['role'=>$role->slug])}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>
        @endforeach
    @endif
@endsection
