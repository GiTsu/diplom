@extends('layouts.admin')
@section('pageTitle', 'Карточка пользователя')
@section('pageSubTitle', '')
@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            Данные
        </div>

        <div class="card-body">
            <div>
                <table class="table">
                    <tr>
                        <td>
                            имя:
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                    </tr>
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

            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'admin.users.edit_form',
            'buttonTitle'=>'Редактировать',
            'buttonClass'=>'btn mr-2 mb-2 btn-success',
            'modalTitle'=>'Редактирование пользователя',
            'user'=>$user
            ])


            @widget('GenericModalWidget', [
            'modal'=>true,
            'includeView'=>'widgets.modals.set_pwd',
            'buttonTitle'=>'Сменить пароль',
            'modalTitle'=>'Изменение пароля',
            'user'=>$user
            ])

            {{Form::open(['route'=>['user.destroy', $user->id], 'method'=>'delete'])}}
            {{Form::submit('Удалить', ['class' => 'btn mr-2 mb-2 btn-danger']) }}
            {{Form::close()}}
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Доступ
                </div>
                <div class="card-body">
                    @forelse($roles=$user->getRoles() as $roleSlug)
                        <div> {{$roleSlug}} <a href="{{route('user:removeRole', [$user->id, $roleSlug])}}">удалить</a>
                        </div>
                    @empty
                        Пользователю не присвоены роли
                    @endforelse
                </div>
                <div class="card-footer">
                    @widget('GenericModalWidget', [
                    'modal'=>true,
                    'includeView'=>'widgets.modals.set_role',
                    'buttonTitle'=>'Добавить роль',
                    'modalTitle'=>'Добавление роли',
                    'user'=>$user,
                    'availableRoles' => $availableRoles
                    ])
                </div>
            </div>
        </div>
        <div class="col">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Учебная группа
                </div>
                <div class="card-body">
                    @if($user->group)
                        <div> {{$user->group->title}} </div>
                    @else
                        Пользователю не присвоена учебная группа
                    @endif
                </div>
                <div class="card-footer">
                    @widget('GenericModalWidget', [
                    'modal'=>true,
                    'includeView'=>'widgets.modals.set_group',
                    'buttonTitle'=>'Указать группу',
                    'modalTitle'=>'Выберите учебную группу',
                    'user'=>$user,
                    'availableGroups' => $availableGroups
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
