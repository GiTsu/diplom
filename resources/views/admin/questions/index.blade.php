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
    <div class="page-title-actions">
        <div class="d-inline-block dropdown">
            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                Действия
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true"
                 class="dropdown-menu dropdown-menu-right">
                <ul class="nav flex-column">
                    @if(Route::has('questions.create'))
                        <li class="nav-item">
                            <a href="{{route('questions.create')}}" class="nav-link">
                                <i class="nav-link-icon lnr-picture"></i>
                                <span>Новый вопрос</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
