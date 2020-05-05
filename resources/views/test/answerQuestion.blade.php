@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$question->title}}</div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            {{$question->text}}
                        </div>
                        @if($question->questionItems->isNotEmpty())
                            {{Form::open(['route' => ['test:answer', $result->id], 'method' => 'post']) }}
                            {{Form::hidden('question_id', $question->id)}}
                            @foreach($question->questionItems as $qItem)
                                <div class="alert alert-info">
                                    {{--dd($qItem)--}}
                                    {{ Form::radio('question_items_id', $qItem->id,  ['id' => 'answer']) }}

                                    {{$qItem->text}}
                                </div>
                                @if ($loop->last)
                                    <div class="alert alert-success">
                                        {{ Form::submit('Ответить', ['class' => 'form-control'])}}
                                    </div>
                                @endif
                            @endforeach

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
