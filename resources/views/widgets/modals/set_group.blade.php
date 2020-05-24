{{Form::open(['route' => ['user:setGroup', 'user'=>$user->id]])}}

<div class="form-group">
    {{Form::label('group_id', 'Учебная группа')}}
    {{Form::select('group_id',$availableGroups, $user->group->id ?? null, ['class' => 'form-control', 'placeholder'=>'Нет группы'])}}
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
{{Form::close()}}
