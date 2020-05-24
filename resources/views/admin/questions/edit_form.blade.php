<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::model($question,['route' => ['questions.update', $question->id], 'method'=>'put'])}}
                <div class="form-group">
                    {{Form::label('title', 'Название вопроса')}}
                    {{Form::text('title', null, ['class' => 'form-control'])}}
                    <small class="form-text text-muted">отображается в списках</small>
                </div>

                <div class="form-group">
                    {{Form::label('subject_id', 'Предмет')}}
                    {{Form::select('subject_id',$subjects, null, ['class' => 'form-control', 'placeholder'=>'Выберите предмет'])}}
                    <small class="form-text text-muted">предметная область</small>
                </div>

                <div class="form-group">
                    {{Form::label('text', 'Текст вопроса')}}
                    <small class="form-text text-muted">полный текст вопроса с картинками</small>
                    {{Form::textarea('text', null, ['class' => 'form-control', 'hidden'=>true, 'id'=>'text'])}}
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
<script>
    Laraberg.initGutenberg('text', {laravelFilemanager: true})
</script>
