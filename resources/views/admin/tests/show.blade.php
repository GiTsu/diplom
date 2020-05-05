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
                <table class="table table-striped">
                    <tr>
                        <td>
                            Создан:
                        </td>
                        <td>
                            {{ $test->creator->name ?? 'не определено'  }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доступен возврат:
                        </td>
                        <td>
                            {{($test->opt_return==1)?'да':'нет'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Доступен пропуск:
                        </td>
                        <td>
                            {{($test->opt_skip==1)?'да':'нет'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Завершить все вопросы:
                        </td>
                        <td>
                            {{($test->opt_fullonly==1)?'да':'нет'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ограничение по времени:
                        </td>
                        <td>
                            {{($test->opt_notime==1)?'да':'нет'}}
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
            @forelse($test->questions as $question)
                <div>
                    <a href="{{route('questions.show', [$question->id])}}">
                        {{$question->title}}
                    </a>
                    <a href="#" class="btn btn-danger">отвязать</a>
                </div>
            @empty
                У теста еще нет вопросов
            @endforelse
        </div>
        <div class="card-footer">
            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'admin.questions.create_form',
            'buttonTitle'=>'Добавить вопрос',
            'modalTitle'=>'Добавление вопроса',
            'test'=>$test,
            'questionTypes'=>$questionTypes
            ])
            <button class="btn mr-2 mb-2 btn-primary">Выбрать существующий</button>
        </div>
    </div>
@endsection
