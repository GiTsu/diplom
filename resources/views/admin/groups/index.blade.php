@extends('layouts.admin')
@section('pageTitle', 'Список групп')
@section('pageSubTitle', '')
@section('content')
    {{ $groups->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Человек</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($groups as $group)
            <tr>
                <th scope="row">{{$group->id}}</th>
                <td>
                    <a href="{{route('groups.show', [$group->id])}}">
                        {{$group->title}}
                    </a>
                </td>
                <td>
                    {{$group->students->count()}}
                </td>
                <th>
                    {{Form::open(['route'=>['groups.destroy', $group->id], 'method'=>'delete'])}}
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
    'includeView'=>'admin.groups.create_form',
    'buttonTitle'=>'Новая группа',
    'modalTitle'=>'Добавление новой группы',
    ])
@endsection
