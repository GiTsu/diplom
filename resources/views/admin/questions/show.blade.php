@extends('layouts.admin')
@section('pageTitle', 'Просмотр вопроса')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            {{$question->title}}
        </div>
        <div class="card-body">
            {{$question->text}}
            <div>
                <table class="table">
                    <tr>
                        <td>
                            Тип:
                        </td>
                        <td>
                            {{$question->type_id}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Текст:
                        </td>
                        <td>
                            {{$question->text}}
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
            @if($question->questionItems->isNotEmpty())
            @else
                У вопроса еще нет вариантов ответа
            @endif
        </div>
        <div class="card-footer">
            @widget('AddQuestionItem')
        </div>
    </div>
@endsection
