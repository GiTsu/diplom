@extends('layouts.admin')
@section('pageTitle', 'Просмотр вопроса')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            {{$question->title}}
        </div>
        <div class="card-body">
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
            Варианты ответа
        </div>
        <div class="card-body">
            @forelse($question->questionItems as $questionItem)
                <div>
                    {{$questionItem->text}}
                    <div>
                        Правильность: {{$questionItem->is_correct?'Да':'Нет'}}
                    </div>
                </div>
            @empty
                У вопроса еще нет вариантов ответа
            @endforelse
        </div>
        <div class="card-footer">
            @widget('AddQuestionItem', ['question'=>$question])
        </div>
    </div>
@endsection
