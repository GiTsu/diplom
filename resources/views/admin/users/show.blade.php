@extends('layouts.admin')
@section('pageTitle', 'Карточка пользователя')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            {{$user->name}}
        </div>
        <div class="card-body">
            <div>
                <table class="table">
                    <tr>
                        <td>
                            email:
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer">
            Редактировать Удалить
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header">
            Доступ
        </div>
        <div class="card-body">
            @if($roles=$user->getRoles())
                {{implode(', ',$roles)}}
            @else
                Пользователю не присвоены роли
            @endif
        </div>
        <div class="card-footer">
            Добавить
        </div>
    </div>
@endsection
