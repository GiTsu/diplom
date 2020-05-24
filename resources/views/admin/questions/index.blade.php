@extends('layouts.admin')
@section('pageTitle', 'Список вопросов')
@section('pageSubTitle', '')
@section('content')
    <div class="row">
        <div class="col">
            {{Form::open(['method'=>'GET'])}}
            <div class="card my-2">
                <div class="card-body">
                    <div class="form-group">
                        {{Form::label('subject_id', 'Предмет')}}
                        {{Form::select('subject_id', $subjects, request('subject_id'), ['class'=>'form-control', 'placeholder'=>''])}}
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
            <th>Тип</th>
            <th>Предмет</th>
            <th>Название</th>
            <th>Ответов</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($questions as $question)
            <tr>
                <th scope="row">{{$question->id}}</th>
                <td>{{$questionTypes[$question->type_id] ?? 'не существует'}}</td>
                <td>{{$question->subject->title ?? 'не указан'}}</td>
                <td>
                    <a href="{{route('questions.show', ['question'=>$question->id])}}">
                        {{$question->title}}
                    </a>
                </td>
                <td>0</td>
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
