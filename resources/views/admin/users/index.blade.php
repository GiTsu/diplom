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
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('actionsMenu')
    <div class="page-title-actions">
        <div class="d-inline-block dropdown">
            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                Действия
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true"
                 class="dropdown-menu dropdown-menu-right">
                <ul class="nav flex-column">
                    @if(Route::has('questions.create'))
                        <li class="nav-item">
                            <a href="{{route('user.create')}}" class="nav-link">
                                <i class="nav-link-icon lnr-picture"></i>
                                <span>Добавить пользователя</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
