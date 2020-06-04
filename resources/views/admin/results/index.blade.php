@extends('layouts.admin')
@section('pageTitle', 'Ответы и оценки')
@section('pageSubTitle', '')
@section('content')
    <div class="row">
        <div class="col">
            {{Form::open(['method'=>'GET'])}}
            <div class="card my-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('test_id', 'Тест')}}
                                {{Form::select('test_id', $tests, request('test_id'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('group_id', 'Группа')}}
                                {{Form::select('group_id', $groups, request('group_id'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('day', 'Число')}}
                                {{Form::date('day', request('day'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('mark', 'Оценка')}}
                                {{Form::select('mark', $marks, request('mark'), ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {{Form::submit('Поиск', ['class'=>'btn btn-sn btn-primary'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>

    {{ $results->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Тест</th>
            <th>Пользователь</th>
            <th>Время</th>
            <th>Оценка</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($results as $result)
            <tr>
                <th scope="row">{{$result->id}}</th>
                <td>{{$result->test->title ?? 'тест не задан'}}</td>
                <td>{{$result->user->name ?? 'пользователь не существует'}}</td>
                <td>
                    @if(!empty($result->start_at))
                        <a title="{{$result->start_at}}">начат</a>
                    @endif
                    @if(!empty($result->end_at))
                        ,   <a title="{{$result->end_at}}">закончен</a>
                    @endif
                    @if(!empty($result->start_at) && !empty($result->end_at))
                        ,   <a title="{{$result->end_at}}"> {{$result->end_at->diffInMinutes($result->start_at)}}
                            мин</a>
                    @endif
                </td>
                <td>
                    @if(!empty($result->mark))
                        <a href="{{route('admin:results:retest', [$result->user_id, $result->test_id])}}"
                           class="btn btn-sm btn-outline-success">задать снова</a>
                        {{$result->percent}}%, {{$marks[$result->mark]}}
                    @else
                        @if (!empty($result->end_at))
                            <a href="{{route('test:showEvaluate', [$result->id])}}" class="btn btn-sm btn-warning">оценить</a>
                        @else
                            не пройден
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('actionsMenu')
@endsection
