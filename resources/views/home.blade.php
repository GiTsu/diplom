@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Назначенные прохождения тестов</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Начат</th>
                                <th>Закончен</th>
                                <th>%</th>
                                <th>Оценка</th>
                                <th></th>
                            </tr>

                            @forelse($user->results as $result)
                                <tr>
                                    <td>{{$result->test->id}}</td>
                                    <td>{{$result->test->title}}</td>
                                    <td>{{$result->start_at ?? 'не начинался'}}</td>
                                    <td>{{$result->end_at ?? 'не закончен'}}</td>
                                    <td>{{$result->percent ?? 'тест не оценен'}}</td>
                                    <td>{{$result->mark ?? 'без оценки'}}</td>
                                    <td>
                                        @if(empty($result->end_at))
                                            <a class="btn btn-primary" href="{{route('test:next', [$result->id])}}">Начать/Продолжить</a>
                                        @else
                                            ---
                                        @endif

                                    </td>
                                </tr>

                            @empty
                                Вам не назначены тесты
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
