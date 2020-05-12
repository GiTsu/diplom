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
            {{-- TODO: вывод вариантов ответа в зависимости от типа--}}
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
                </tr>

                @forelse($question->questionItems as $questionItem)
                    <tr>
                        <td>
                            @if($question->type_id!=\App\Models\Question::COMPLY_QUESTION)
                                <span class="badge badge-{{$questionItem->is_correct?'success':'warning'}}">
                                {{$questionItem->is_correct?'Да':'Нет'}}
                            </span>
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
@endsection
