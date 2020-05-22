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
    @if(Route::has('tests.create'))
        <a href="{{route('tests.create')}}" class="btn btn-success">
            <i class="nav-link-icon lnr-picture"></i>
            <span>Новый тест</span>
        </a>
    @endif
@endsection
