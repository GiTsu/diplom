@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Редактировать</h4>
    <div class="row">
        <div class="col">
            {{Form::model($permission,['route'=> ['permission.update', $permission->id], 'method'=>'put', 'id'=>'permissionForm'])}}
            <div class="form-group">
                {{Form::label('inherit_id', 'Наследовать от')}}
                {{Form::select('inherit_id', $permissionArr, null, ['class'=>'form-control', 'placeholder'=>'сам по себе'])}}
            </div>
            <div class="form-group">
                {{Form::label('name', 'Идентификатор')}}
                {{Form::text('name', null, ['class'=>'form-control'])}}
                <small class="form-text text-muted">
                    Используется как $user->can('action.id'); can(['one', 'another'], 'or'); can('one|another');
                </small>
            </div>
            <div class="form-group">
                {{Form::label('description', 'Описание')}}
                {{Form::textarea('description', null, ['class'=>'form-control'])}}
            </div>
            <div class="text-right">
            {{Form::submit('Редактировать')}}
            </div>
            {{Form::close()}}
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Разрешения @widget('AddPermissionItem', ['modal'=>1, 'permission'=>$permission])
                </div>
                <ul class="list-group list-group-flush">
                    @if(!empty($permission->slug))
                        @foreach($permission->slug as $key=>$value)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-6"> {{Form::label("slug[{$key}]", $key)}}.{{$permission->name}} </div>
                                    <div class="col-3">
                                        {{Form::checkbox("slug[{$key}]", null, $value, ['form'=>'permissionForm'])}}
                                    </div>
                                    <div class="col-3">
                                        <a href="{{route('permission:removeslug', ['permission'=>$permission->id, 'slug'=>$key])}}">
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
