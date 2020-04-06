{{Form::open(['route' => ['user:assignTest', 'user'=>$user->id]])}}

<div class="form-group">
    {{Form::label('test_id', 'Роль ')}}
    {{Form::select('test_id',$availableTests, '', ['class' => 'form-control'])}}
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
{{Form::close()}}
