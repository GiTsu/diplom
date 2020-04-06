{{Form::open(['route' => ['user:setPassword', 'user'=>$user->id]])}}

<div class="form-group">
    {{Form::label('password', 'Пароль')}}
    {{Form::text('password', '', ['class' => 'form-control'])}}
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
{{Form::close()}}
