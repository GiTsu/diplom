@extends('layouts.admin')
@section('pageTitle', 'Новый вопрос')
@section('pageSubTitle', '')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{Form::open(['route' => 'questions.store'])}}

                    <div class="form-group">
                        {{Form::label('title', 'Название вопроса')}}
                        {{Form::text('title', '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">отображается в списках</small>
                    </div>

                    <div class="form-group">
                        {{Form::label('type_id', 'Тип вопроса')}}
                        {{Form::select('type_id',[1=>'Создать типы'], '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">в минутах</small>
                    </div>

                    <div class="form-group">
                        {{Form::label('text', 'Текст вопроса')}}
                        {{Form::textarea('text', '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">краткое описание</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
@endsection
