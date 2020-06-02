@extends('layouts.admin')
@section('pageTitle', 'Оценка результата теста')
@section('pageSubTitle', 'Подзаголовок')
@section('content')
    <style>
        .status-chosen {
            background-color: #b0d4f1;
        }
    </style>
    <div class="card mb-2">
        <div class="card-header">
            Ответы на тест
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    @if($result->answers)
                        @foreach($result->answers as $answer)
                            @php
                                $correct=\App\Services\TestService::checkCorrect($answer);
                                $marked=0;
                                if ($correct===true) {
                                    $questionsCorrectCount++;
                                }
                                if ($correct===null) {
                                    $marked++;
                                }
                            @endphp
                            <div class="alert alert-info">
                                <div>
                                    <div class="font-weight-bold mb-2">Вопрос:</div>
                                    <div class="alert alert-light">
                                        <div class="font-weight-bold">{{$answer->question->title}}</div>
                                        {!! $answer->question->text !!}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold  mb-2">Ответ пользователя:</div>
                                    <div class="alert alert-light">
                                        {{--вывод согласно типу вопроса--}}
                                        @switch($answer->question->type_id)
                                            @case(\App\Models\Question::SINGLE_QUESTION)
                                            @php
                                                $item = \App\Models\QuestionItem::query()->whereIn('id', [$answer->value])->each(
                                                    function($value, $key){
                                                        //$json= json_decode();
                                                        echo('<div>'.$value->text.'</div>');
                                                    }
                                                );
                                            @endphp

                                            @break
                                            @case(\App\Models\Question::MULTI_QUESTION)
                                            @php
                                                $items = \App\Models\QuestionItem::query()->whereIn('id', json_decode($answer->value))->each(
                                                    function($value, $key){
                                                        //$json= json_decode();
                                                        echo('<div>'.$value->text.'</div>');
                                                    }
                                                );
                                            @endphp

                                            @break
                                            @case(\App\Models\Question::ENTER_QUESTION)
                                            {{$answer->value}}
                                            @break
                                            @case(\App\Models\Question::COMPLY_QUESTION)
                                            @php
                                                $sootv=json_decode($answer->value);
                                                if ($sootv){
                                                    foreach ($sootv as $parent=>$child){
                                                        //dd($parent, $child);
                                                        $parentItem = \App\Models\QuestionItem::query()->find((int)$parent);
                                                        $childItem = \App\Models\QuestionItem::query()->find((int)$child);
                                                        if ($parentItem && $childItem){
                                                            echo('<div>'.$parentItem->text.' : '.$childItem->text.'</div>');
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @break
                                        @endswitch
                                    </div>
                                </div>

                                <div
                                    class="alert alert-light status-box {{($correct===true)?'status-correct':''}} {{($correct===false)?'status-incorrect':''}}"
                                    data-status="">
                                    <div class="row">
                                        @if (($correct==null) || ($correct==true))
                                            <div class="col">
                                                <a class="btn btn-block btn-outline-success font-weight-bold status-change {{($correct===true)?'status-chosen':''}}"
                                                   data-status="1">
                                                    Верно
                                                </a>
                                            </div>
                                        @endif
                                        @if (($correct==null) || ($correct==false))
                                            <div class="col">
                                                <a class="btn btn-block btn-outline-danger  font-weight-bold  status-change  {{($correct===false)?'status-chosen':''}}"
                                                   data-status="0">
                                                    Не верно
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        Нет ответов на вопросы
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Оценка
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <div class="row">
                    <div class="col text-center">
                        Вопросов в тесте: {{$questionsCount}}
                    </div>
                    <div class="col text-center">
                        Ответов: {{$result->answers->count()}}
                    </div>
                    <div class="col text-center">
                        Правильных:
                        <span id="showCorrect">{{$questionsCorrectCount}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{Form::model($result,['route'=> ['test:putEvaluate', $result->id], 'method'=>'put', 'id'=>'editResult'])}}

                    <div class="form-group">
                        {{Form::label('percent', 'Процент правильных')}}
                        {{Form::text('percent', $result->percent.'%', ['class'=>'form-control', 'readonly'=>true])}}
                        <small class="form-text text-muted">
                            определяется в интерфейсе кнопками "Правильно"/"Не правильно"
                        </small>
                    </div>
                    <div class="form-group">
                        {{Form::label('mark', 'Оценка')}}
                        {{Form::select('mark', $markArr, null, ['class'=>'form-control', 'placeholder'=>'без оценки'])}}
                    </div>
                    <div class="text-right">
                        {{Form::hidden('marked_questions',$marked, ['class'=>'', 'id'=>'marked_questions'])}}
                        {{Form::submit('Поставить оценку', ['class'=>'btn btn-primary'])}}
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function recalc_percent() {
            var total = {{$questionsCount}};
            var correct = $('.status-correct').length;
            var percent = (total != 0) ? correct / total : 0;
            var incorrect = $('.status-incorrect').length;
            $('#marked_questions').val(correct + incorrect);
            console.log(total);
            console.log(correct);
            $('#showCorrect').html(correct);
            $('#percent').val(100 * percent + '%');
        }

        $(document).ready(function () {
            $('.status-change').click(function () {
                var status = $(this).data('status');
                console.log(status);
                if (status == '1') {
                    // отметить как верный
                    $(this).parents('.status-box').each(function (index, element) {
                        //console.log(element);
                        $(element).removeClass('status-incorrect');
                        $(element).find('a.status-change').removeClass('status-chosen');
                        $(element).addClass('status-correct');
                        $(element).data('status', '1');
                        //console.log($(element).data('status'));
                    });
                } else {
                    // отметить как не верный
                    $(this).parents('.status-box').each(function (index, element) {
                        $(element).removeClass('status-correct');
                        $(element).find('a.status-change').removeClass('status-chosen');
                        $(element).addClass('status-incorrect');
                        $(element).data('status', '0');
                        //console.log($(element).data('status'));
                    });
                }
                $(this).addClass('status-chosen');
                recalc_percent();
            });
            console.log("ready!");
            recalc_percent();
        });
    </script>
@endsection
@section('actionsMenu')

@endsection
