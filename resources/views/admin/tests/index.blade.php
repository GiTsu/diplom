@extends('layouts.admin')
@section('pageTitle', 'Список тестов')
@section('pageSubTitle', 'Подзаголовок')
@section('content')
    {{ $tests->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Составитель</th>
            <th>Вопросов</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($tests as $test)
            <tr>
                <th scope="row">{{$test->id}}</th>
                <td>
                    <a href="{{route('tests.show', ['test'=>$test->id])}}">
                        {{$test->title}}
                    </a>
                </td>
                <td>{{$test->creator->name ?? 'не определено'}}</td>
                <td>{{count($test->questions)}}</td>
                <th></th>
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
                    @if(Route::has('tests.create'))
                        <li class="nav-item">
                            <a href="{{route('tests.create')}}" class="nav-link">
                                <i class="nav-link-icon lnr-picture"></i>
                                <span>Новый тест</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
