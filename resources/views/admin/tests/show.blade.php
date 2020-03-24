@extends('layouts.admin')
@section('pageTitle', 'Просмотр теста')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            {{$test->title}}
        </div>
        <div class="card-body">
            {{$test->description}}
            <div>
                <table class="table">
                    <tr>
                        <td>
                            Создан:
                        </td>
                        <td>
                            Кем, Дата, Редактирован:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доступен возврат:
                        </td>
                        <td>
                            {{$test->opt_return}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доступен пропуск:
                        </td>
                        <td>
                            {{$test->opt_skip}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Завершить все вопросы:
                        </td>
                        <td>
                            {{$test->opt_fullonly}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ограничение по времени:
                        </td>
                        <td>
                            {{$test->opt_notime}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer">
            Редактировать Удалить
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header">
            Вопросы теста
        </div>
        <div class="card-body">
            @if($test->questions->isNotEmpty())
            @else
                У теста еще нет вопросов
            @endif
        </div>
        <div class="card-footer">
            Добавить TODO: попап с вводом айди, потом заменить на выпадающий список
        </div>
    </div>
@endsection
