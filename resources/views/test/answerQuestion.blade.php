@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$question->title}} (id#{{$question->id}})</div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            <div class="font-weight-bold">Вопрос:</div>
                            <div class="alert alert-light">{!! $question->text  !!}</div>
                        </div>
                        @if($question->questionItems->isNotEmpty() || ($question->type_id==\App\Models\Question::ENTER_QUESTION))
                            {{Form::open(['route' => ['test:answer', $result->id], 'method' => 'post']) }}
                            {{Form::hidden('question_id', $question->id)}}
                            @if($question->questionItems->isNotEmpty())
                                @if($question->type_id==\App\Models\Question::COMPLY_QUESTION)
                                    {{-- соответствие --}}

                                    @php
                                        $areLinked = $question->questionItems->filter(function ($value, $key) {
                                            return !empty($value->linked_id);
                                        });
                                        $areNotLinked = $question->questionItems->filter(function ($value, $key) {
                                            return empty($value->linked_id);
                                        });
                                        $sootv = (!empty($answerItem))?json_decode($answerItem->value, true):[];

                                        $areNotLinkedList = \App\Helpers\FormatHelper::getObjectsCollectionFormSelectData($areNotLinked, 'id', 'text');
                                    @endphp
                                    @foreach($areLinked as $variantItem)
                                        <div class="alert alert-info">
                                            {{$variantItem->text}}
                                            : {{Form::select('linked['.$variantItem->id.']', $areNotLinkedList, $sootv[$variantItem->id] ?? null, ['class'=>''])}}
                                        </div>
                                    @endforeach

                                @else
                                    {{-- варианты ответа --}}
                                    @foreach($question->questionItems as $qItem)
                                        <div class="alert alert-info">
                                            @if($question->type_id==\App\Models\Question::MULTI_QUESTION)

                                                {{ Form::checkbox('value[]', $qItem->id, (!empty($answerItem) && in_array($qItem->id, json_decode($answerItem->value))),  ['id' => 'answer_'.$qItem->id]) }}
                                            @else
                                                {{ Form::radio('value', $qItem->id, (!empty($answerItem) && ($qItem->id==$answerItem->value)),  ['id' => 'answer']) }}
                                            @endif
                                            {{$qItem->text}}
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                            @if(($question->type_id==\App\Models\Question::ENTER_QUESTION))
                                {{-- ввод ручками--}}
                                <div class="alert alert-secondary">
                                    {{ Form::textarea('value', $answerItem->value ?? null,  ['id' => 'answer']) }}
                                </div>
                            @endif

                            <div class="alert alert-dark">
                                {{ Form::submit('Ответить', ['class' => 'btn btn-block btn-success font-weight-bold'])}}
                            </div>

                            {{Form::close()}}
                        @else
                            <div class="alert alert-danger">
                                не нашлись варианты ответа, обратитесь к администратору
                            </div>
                        @endif

                    </div>
                    <div class="card-footer">
                        <div class="my-2">
                            <h5>Информация и действия</h5>
                            <ul>
                                <li>
                                    Тест начат: {{$result->start_at}}
                                    @if(!empty($result->test->opt_timelimit))
                                        Ограничение по
                                        времени: {{$result->start_at->addMinutes($result->test->opt_timelimit)}}
                                    @else
                                        Тест не ограничен по времени
                                    @endif
                                </li>
                                <li>
                                    возврат по вопросам
                                    @if(!empty($result->test->opt_return))
                                        разрешен
                                    @else
                                        запрещен
                                    @endif
                                </li>
                                <li>
                                    пропускать вопросы
                                    @if(!empty($result->test->opt_skip))
                                        можно
                                    @else
                                        нельзя
                                    @endif
                                </li>
                                <li>
                                    @if(!empty($result->test->opt_fullonly))
                                        завершить тест можно только после ответа на все вопросы
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="alert alert-light">

                            <a class="btn btn-outline-secondary"
                               href="{{route('test:next',['result'=>$result->id, 'goPrevious'=>$question->id])}}">
                                Предыдущий вопрос
                            </a>
                            <a class="btn btn-outline-secondary"
                               href="{{route('test:next',['result'=>$result->id, 'goNext'=>$question->id])}}">
                                Следующий вопрос
                            </a>
                            <a class="btn btn-outline-danger"
                               href="{{route('test:next',['result'=>$result->id, 'finish'=>true])}}">
                                Завершить тест
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
