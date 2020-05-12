<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => 'questions.store'])}}
                @if(!empty($test))
                    {{ Form::hidden('test_id', $test->id, []) }}
                @endif
                <div class="form-group">
                    {{Form::label('title', 'Название вопроса')}}
                    {{Form::text('title', '', ['class' => 'form-control'])}}
                    <small class="form-text text-muted">отображается в списках</small>
                </div>

                <div class="form-group">
                    {{Form::label('type_id', 'Тип вопроса')}}
                    {{Form::select('type_id',$questionTypes, '', ['class' => 'form-control'])}}
                    <small class="form-text text-muted">задает манеру ответа</small>
                </div>

                <div class="form-group">
                    {{Form::label('text', 'Текст вопроса')}}
                    {{Form::textarea('text', '', ['class' => 'form-control'])}}
                    <small class="form-text text-muted">краткое описание</small>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
