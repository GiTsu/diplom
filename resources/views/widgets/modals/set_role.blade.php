{{Form::open(['route' => ['user:addRole', 'user'=>$user->id]])}}

<div class="form-group">
    {{Form::label('role_id', 'Роль ')}}
    {{Form::select('role_id',$availableRoles, '', ['class' => 'form-control'])}}
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
{{Form::close()}}
