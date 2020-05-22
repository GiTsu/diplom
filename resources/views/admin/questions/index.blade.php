@extends('layouts.admin')
@section('pageTitle', 'Список вопросов')
@section('pageSubTitle', '')
@section('content')
    {{ $questions->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Тип</th>
            <th>Название</th>
            <th>Ответов</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($questions as $question)
            <tr>
                <th scope="row">{{$question->id}}</th>
                <td>тип-здесь</td>
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
        <li class="nav-item">
            <a href="{{route('questions.create')}}" class="btn btn-success">
                <i class="nav-link-icon lnr-picture"></i>
                <span>Новый вопрос</span>
            </a>
        </li>
    @endif
@endsection
