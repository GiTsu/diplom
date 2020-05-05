@extends('layouts.admin')
@section('pageTitle', 'Оценка результата теста')
@section('pageSubTitle', 'Подзаголовок')
@section('content')
    <div class="card mb-2">
        <div class="card-header">
            Ответы на тест
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    @if($result->answers)
                        @foreach($result->answers as $answer)
                            <div class="alert alert-info">
                                <div>
                                    <div class="font-weight-bold mb-2">Вопрос:</div>
                                    <div class="alert alert-light">
                                        <div class="font-weight-bold">{{$answer->question->title}}</div>
                                        {{$answer->question->text}}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold  mb-2">Ответ пользователя:</div>
                                    <div class="alert alert-light">
                                        {{$answer->questionItem->text}}
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        Нет ответов на вопросы
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Оценка
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{Form::model($result,['route'=> ['test:putEvaluate', $result->id], 'method'=>'put', 'id'=>'editResult'])}}

                    <div class="form-group">
                        {{Form::label('percent', 'Процент правильных')}}
                        {{Form::text('percent', null, ['class'=>'form-control'])}}
                        <small class="form-text text-muted">
                            определяется в интерфейсе
                        </small>
                    </div>
                    <div class="form-group">
                        {{Form::label('mark', 'Оценка')}}
                        {{Form::select('mark', $markArr, null, ['class'=>'form-control', 'placeholder'=>'без оценки'])}}
                    </div>
                    <div class="text-right">
                        {{Form::submit('Редактировать')}}
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('actionsMenu')

@endsection
