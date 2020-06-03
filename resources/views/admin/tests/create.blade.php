@extends('layouts.admin')
@section('pageTitle', 'Новый тест')
@section('pageSubTitle', '')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{Form::open(['route' => 'tests.store'])}}

                    <div class="form-group">
                        {{Form::label('title', 'Название теста')}}
                        {{Form::text('title', '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">отображается в списках</small>
                    </div>

                    <div class="form-group">
                        {{Form::label('description', 'Описание теста')}}
                        {{Form::textarea('description', '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">краткое описание</small>
                    </div>

                    <div class="form-group form-check">
                        {{Form::checkbox('opt_skip', 1, true,  ['class'=>'form-check-input'])}}
                        {{Form::label('opt_skip', 'Можно пропускать вопросы', ['class'=>'form-check-label'])}}
                    </div>

                    <div class="form-group form-check">
                        {{Form::checkbox('opt_return', 1, true,  ['class'=>'form-check-input'])}}
                        {{Form::label('description', 'Можно возвращаться к пропущенным', ['class'=>'form-check-label'])}}
                    </div>

                    <div class="form-group form-check">
                        {{Form::checkbox('opt_fullonly', 1, true,  ['class'=>'form-check-input'])}}
                        {{Form::label('opt_fullonly', 'Завершать только со всеми ответами', ['class'=>'form-check-label'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('opt_timelimit', 'Длительность теста')}}
                        {{Form::number('opt_timelimit', '', ['class' => 'form-control'])}}
                        <small class="form-text text-muted">в минутах</small>
                    </div>

                    <div class="form-group form-check">
                        {{Form::checkbox('opt_notime', 1, true,  ['class'=>'form-check-input'])}}
                        {{Form::label('opt_notime', 'Без ограничений по времени', ['class'=>'form-check-label'])}}
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
@endsection
