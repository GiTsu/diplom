@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Редактирование</h4>
    <div class="row">
        <div class="col">
            {{Form::model($role,['route'=> ['role.update', $role->id], 'method'=>'put', 'id'=>'roleForm'])}}
            <div class="form-group">
                {{Form::label('name', 'Название')}}
                {{Form::text('name', null, ['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('slug', 'Идентификатор')}}
                {{Form::text('slug', null, ['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('description', 'Описание')}}
                {{Form::textarea('description', null, ['class'=>'form-control'])}}
            </div>
            {{Form::submit('Редактировать')}}

            {{Form::close()}}
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Разрешения @widget('AddRolePermission', ['modal'=>1, 'role'=>$role,
                    'permissionArr'=>$permissionArr])
                </div>
                <ul class="list-group list-group-flush">
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $key=>$value)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col"> {{$key}} </div>
                                    <div class="col">

                                    </div>
                                    <div class="col">
                                        <a href="{{route('role:revokeperm', ['role'=>$role->id, 'permission'=>$key])}}">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
