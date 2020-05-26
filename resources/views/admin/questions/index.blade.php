@extends('layouts.admin')
@section('pageTitle', 'Список вопросов')
@section('pageSubTitle', '')
@section('content')
    <div class="row">
        <div class="col">
            {{Form::open(['method'=>'GET'])}}
            <div class="card my-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('subject_id', 'Предмет')}}
                                {{Form::select('subject_id', $subjects, request('subject_id'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('type_id', 'Тип ответа')}}
                                {{Form::select('type_id', $questionTypes, request('type_id'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    {{Form::submit()}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>

    {{ $questions->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Предмет</th>
            <th>Тип</th>
            <th>Ответов</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($questions as $question)
            <tr>
                <th scope="row">{{$question->id}}</th>
                <td>
                    <a href="{{route('questions.show', ['question'=>$question->id])}}" target="_blank">
                        {{$question->title}}
                    </a>
                </td>
                <td>{{$question->subject->title ?? 'не указан'}}</td>
                <td>{{$questionTypes[$question->type_id] ?? 'не существует'}}</td>
                <td>{{$question->questionItems->count()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('actionsMenu')
    @if(Route::has('questions.create'))
        <a href="{{route('questions.create')}}" class="btn btn-success">
            <i class="nav-link-icon lnr-picture"></i>
            <span>Новый вопрос</span>
        </a>
    @endif
@endsection
