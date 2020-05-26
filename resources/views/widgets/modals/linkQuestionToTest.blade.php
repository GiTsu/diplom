{{Form::open(['route' => ['question:assignTest', 'question'=>$question->id]])}}
<div class="form-group">
    {{Form::label('test_id', 'Тест')}}
    {{Form::select('test_id', $testsAvailable, null, ['class' => 'form-control'])}}
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
{{Form::close()}}
