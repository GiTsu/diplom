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
                            {{($test->opt_notime==1)?'нет':$test->opt_timelimit. ' мин.'}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer">

            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'admin.tests.assign_group',
            'buttonTitle'=>'Задать тест учащимся',
            'modalTitle'=>'Кому выполнить тест',
            'test'=>$test,
            'groups'=>$groups,
            ])
            <a href="{{route('tests.edit', [$test->id])}}" class="btn btn-primary mr-2 mb-2">Редактировать</a>
            {{Form::open(['route' => ['tests.destroy', $test->id], 'method'=>'delete'])}}
            {{Form::submit('Удалить', ['class'=>'btn btn-danger mr-2 mb-2'])}}
            {{Form::close()}}

        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header">
            Вопросы теста
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @forelse($test->questions as $question)
                    <tr>
                        <td>
                            <div>
                                <a href="{{route('questions.show', [$question->id])}}">
                                    {{$question->title}}
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{{route('questions:unlink',['questionItem'=>$question->id, 'testId'=>$test->id])}}"
                               class="btn btn-danger">отвязать</a>
                        </td>
                    </tr>
                @empty
                    У теста еще нет вопросов
                @endforelse
            </table>
        </div>
        <div class="card-footer">
            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'admin.questions.create_form',
            'buttonTitle'=>'Добавить вопрос',
            'modalTitle'=>'Добавление вопроса',
            'test'=>$test,
            'questionTypes'=>$questionTypes,
            'subjects'=>$subjects
            ])
            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'admin.questions.enter_id',
            'buttonTitle'=>'Выбрать существующий',
            'modalTitle'=>'Выбор существующего',
            'test'=>$test,
            'selectQuestions'=>$selectQuestions,
            ])
        </div>
    </div>
@endsection
