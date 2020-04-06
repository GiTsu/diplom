@extends('layouts.admin')
@section('pageTitle', 'Новый пользователь')
@section('pageSubTitle', '')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{Form::open(['route' => 'user.store'])}}

                    <div class="form-group">
                        {{Form::label('title', 'Имя')}}
                        {{Form::text('name', null, ['class' => 'form-control'])}}
                        <small class="form-text text-muted">ФИО</small>
                    </div>

                    <div class="form-group">
                        {{Form::label('email', 'Имейл')}}
                        {{Form::text('email', null, ['class' => 'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('password', 'Пароль')}}
                        {{Form::text('password', null, ['class' => 'form-control'])}}
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
