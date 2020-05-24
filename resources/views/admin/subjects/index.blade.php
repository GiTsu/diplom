@extends('layouts.admin')
@section('pageTitle', 'Список предметов')
@section('pageSubTitle', '')
@section('content')
    {{ $subjects->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($subjects as $subject)
            <tr>
                <th scope="row">{{$subject->id}}</th>
                <td>
                    {{$subject->title}}
                </td>
                <th>
                    {{Form::open(['route'=>['subjects.destroy', $subject->id], 'method'=>'delete'])}}
                    {{Form::submit('Удалить', ['class'=>'btn btn-danger'])}}
                    {{Form::close()}}
                </th>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
@section('actionsMenu')
    @widget('GenericModalWidget', [
    'modal'=>true,
    'includeView'=>'admin.subjects.create_form',
    'buttonTitle'=>'Новая дисциплина',
    'modalTitle'=>'Добавление новой дисциплины',
    ])
@endsection
