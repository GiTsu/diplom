@extends('layouts.admin')
@section('dopMenu')
    @include('admin.menus.dopMenuACL')
@endsection
@section('content')
    <h4>Создание</h4>
    {{Form::open(['route'=> ['role.store'], 'method'=>'post'])}}

    <div class="form-group">
        {{Form::label('name', 'Название')}} {{Form::text('name', null , ['class'=>'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('slug', 'Идентификатор')}} {{Form::text('slug', null , ['class'=>'form-control'])}}
        <small class="form-text text-muted">
            Используется в проверке доступа, $user->hasRole(); $user->is()
        </small>
    </div>
    <div class="form-group">
        {{Form::label('description', 'Описание')}} {{Form::textarea('description', null , ['class'=>'form-control'])}}
    </div>
    {{Form::submit('Сохранить')}}
    {{Form::close()}}

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
