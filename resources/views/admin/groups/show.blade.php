@extends('layouts.admin')
@section('pageTitle', 'Просмотр группы')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            {{$group->title}}
        </div>
        <div class="card-body">
            <table class="table table-striped table-sm">
                <tr>
                    <th>#</th>
                    <th>Студент</th>
                    <th></th>
                </tr>

                @forelse($group->students as $student)
                    <tr>
                        <td>
                            {{$student->id}}
                        </td>
                        <td>
                            <a href="{{route('user.show',[$student->id])}}" target="_blank">
                                {{$student->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('admin:groups:dismiss',[$student->id])}}" class="btn btn-sm btn-danger">
                                исключить
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            В группе нет учеников
                        </td>
                    </tr>
                @endforelse
            </table>
        </div>
        <div class="card-footer">
            {{Form::open(['route'=>['groups.destroy', $group->id], 'method'=>'delete'])}}
            {{Form::submit('Удалить', ['class'=>'btn btn-danger'])}}
            {{Form::close()}}
        </div>
    </div>
@endsection
