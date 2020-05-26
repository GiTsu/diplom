@extends('layouts.admin')
@section('pageTitle', 'Список пользователей')
@section('pageSubTitle', '')
@section('content')
    {{ $users->links() }}
    <table class="mb-0 table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Имейл</th>
            <th>Роль</th>
            <th>Группа</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>
                    <a href="{{route('user.show', ['user'=>$user->id])}}">
                        {{$user->name}}
                    </a>
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    <?php
                    /** @var $user \App\User */
                    ?>
                    {{implode(',',$user->getRoles())}}
                </td>
                <td>
                    {{$user->group->title ?? 'не указана'}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('actionsMenu')
    @if(Route::has('user.create'))
        <a href="{{route('user.create')}}" class="btn btn-primary">
            <i class="nav-link-icon lnr-picture"></i>
            <span>Добавить пользователя</span>
        </a>
    @endif
@endsection
