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

                                            $areNotLinkedList = \App\Helpers\FormatHelper::getObjectsCollectionFormSelectData($areNotLinked, 'id', 'text');
                                        @endphp
                                        @foreach($areLinked as $variantItem)
                                        <div class="alert alert-info">
                                            {{$variantItem->text}}
                                            : {{Form::select('linked['.$variantItem->id.']', $areNotLinkedList, null, ['class'=>''])}}
                                        </div>
                                        @endforeach

                                @else
                                    {{-- варианты ответа --}}
                                    @foreach($question->questionItems as $qItem)
                                        <div class="alert alert-info">

                                            @if($question->type_id==\App\Models\Question::MULTI_QUESTION)
                                                {{ Form::checkbox('value[]', $qItem->id, null,  ['id' => 'answer_'.$qItem->id]) }}
                                            @else
                                                {{ Form::radio('value', $qItem->id,  ['id' => 'answer']) }}
                                            @endif
                                            {{$qItem->text}}
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                            @if(($question->type_id==\App\Models\Question::ENTER_QUESTION))
                                {{-- ввод ручками--}}
                                <div class="alert alert-info">
                                    {{ Form::textarea('value', null,  ['id' => 'answer']) }}
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
                        след - пред завершить
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
