{{Form::open(['route'=> ['role:addperm', 'role'=>$role->slug], 'method'=>'post'])}}
<div class="form-group">
    {{Form::label('permission_id', 'Группа разрешений')}}
    {{Form::select('permission_id', $permissionArr, null, ['class'=>'form-control'])}}
</div>
{{Form::submit('Сохранить')}}
{{Form::close()}}
