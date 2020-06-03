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
                            {{$qTypes[$question->type_id]}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Текст:
                        </td>
                        <td>
                            {!! $question->text  !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{route('questions.edit', $question->id)}}" class="mr-2 mb-2 btn btn-primary">Редактировать</a>
            {{Form::open(['route'=>['questions.destroy', $question->id], 'method'=>'delete'])}}
            {{Form::submit('Удалить',['class'=>'btn btn-danger mr-2 mb-2'])}}
            {{Form::close()}}
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header">
            Варианты ответа
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <td>
                        Правильный
                    </td>
                    <td>
                        Ответ
                    </td>
                    <td>
                        Соответствие
                    </td>
                    <td></td>
                </tr>

                @forelse($question->questionItems as $questionItem)
                    <tr>
                        <td>
                            @if(in_array($question->type_id,[\App\Models\Question::SINGLE_QUESTION,\App\Models\Question::MULTI_QUESTION]))
                                <a href="{{route('admin:questionItems:toggle',[$questionItem->id])}}"
                                   class="badge badge-{{$questionItem->is_correct?'success':'warning'}}">
                                    {{$questionItem->is_correct?'Да':'Нет'}}
                                </a>
                            @else
                                ---
                            @endif
                        </td>
                        <td>
                            <div>
                                {{$questionItem->text}}
                            </div>
                        </td>
                        <td>
                            @if($question->type_id==\App\Models\Question::COMPLY_QUESTION)
                                {{Form::open(['route'=>['questions:link', $questionItem->id]])}}
                                {{Form::select('linked_id', $linkAvailable, $questionItem->linked_id, ['class'=>'', 'placeholder'=>'не связан'])}}
                                {{Form::submit('Связать')}}
                                {{Form::close()}}
                            @else
                                не требуется
                            @endif
                        </td>
                        <td>
                            {{Form::open(['route'=>['questionItems.destroy', $questionItem->id], 'method'=>'DELETE'])}}
                            {{Form::submit('Удалить', ['class'=>'btn btn-sm btn-danger'])}}
                            {{Form::close()}}
                        </td>
                    </tr>
                @empty
                    У вопроса еще нет вариантов ответа
                @endforelse

            </table>
        </div>
        <div class="card-footer">
            @widget('AddQuestionItem', ['question'=>$question])
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-header">
            Добавлен к тестам:
        </div>
        <div class="card-body">
            <div>
                <table class="table">
                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            название
                        </td>
                        <td>

                        </td>
                    </tr>
                    @if($question->tests)
                        @foreach($question->tests as $test)
                            <tr>
                                <td>
                                    {{$test->id}}
                                </td>
                                <td>
                                    <a href="{{route('tests.show', [$test->id])}}" target="_blank">
                                        {{$test->title}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('questions:unlink',['questionItem'=>$question->id, 'testId'=>$test->id])}}"
                                       class="btn btn-danger">
                                        Отвязать
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <div class="card-footer">
            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'widgets.modals.linkQuestionToTest',
            'buttonTitle'=>'Привязать к тесту',
            'modalTitle'=>'Привязка к тесту',
            'testsAvailable'=>$testsAvailable,
            'question'=>$question,
            ])
        </div>
    </div>
@endsection
