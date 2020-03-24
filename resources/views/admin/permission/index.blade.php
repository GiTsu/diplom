@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Доступы</h4>
    @if (!$permission->isEmpty())
        @foreach($permission as $perm)
            <div class="row">
                <div class="w-25">
                    <a href="{{route('permission.show', ['id'=>$perm->id])}}">{{$perm->name}}</a>
                </div>
                <div class="w-75">
                    <a href="{{route('permission.edit', ['id'=>$perm->id])}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>
        @endforeach
    @endif
@endsection
