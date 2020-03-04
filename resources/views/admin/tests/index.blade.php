@extends('layouts.admin')
@section('pageTitle', 'Список тестов')
@section('pageSubTitle', 'Подзаголовок')
@section('content')
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
        <tr>
            <th scope="row">1</th>
            <td>
                <a href="{{route('tests.show', ['test'=>1])}}">Тест №1</a>
            </td>
            <td>superuser</td>
            <td>2</td>
            <th></th>
        </tr>
        </tbody>
    </table>
@endsection
