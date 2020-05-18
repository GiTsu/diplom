@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$question->title}}</div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            Вопрос: {{$question->text}} (id#{{$question->id}})
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
                                                {{ Form::radio('value', (!empty($answerItem) && ($qItem->id==$answerItem->value)),  ['id' => 'answer']) }}
                                            @endif
                                            {{$qItem->text}}
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                            @if(($question->type_id==\App\Models\Question::ENTER_QUESTION))
                                {{-- ввод ручками--}}
                                <div class="alert alert-info">
                                    {{ Form::textarea('value', $answerItem->value ?? null,  ['id' => 'answer']) }}
                                </div>
                            @endif

                            <div class="alert alert-success">
                                {{ Form::submit('Ответить', ['class' => 'form-control'])}}
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
                            <ul>
                                <li>
                                    Тест начат: {{$result->start_at}}
                                    @if(!empty($test->opt_timelimit))
                                        Ограничение по времени: {{$result->start_at->addMinutes($test->opt_timelimit)}}
                                    @else
                                        Тест не ограничен по времени
                                    @endif
                                </li>
                                <li>
                                    возврат по вопросам
                                    @if(!empty($test->opt_return))
                                        разрешен
                                    @else
                                        запрещен
                                    @endif
                                </li>
                                <li>
                                    пропускать вопросы
                                    @if(!empty($test->opt_skip))
                                        можно
                                    @else
                                        нельзя
                                    @endif
                                </li>
                                <li>
                                    @if(!empty($test->opt_fullonly))
                                        завершить тест можно только после ответа на все вопросы
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div>
                            <a class="btn btn-primary"
                               href="{{route('test:next',['test'=>$test->id, 'goPrevious'=>$question->id])}}">
                                Предыдущий вопрос
                            </a>
                            <a class="btn btn-success"
                               href="{{route('test:next',['test'=>$test->id, 'goNext'=>$question->id])}}">
                                Следующий вопрос
                            </a>
                            <a class="btn btn-warning"
                               href="{{route('test:next',['test'=>$test->id, 'finish'=>true])}}">
                                Завершить тест
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
