<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => 'question:linkTest'])}}
                @if(!empty($test))
                    {{ Form::hidden('test_id', $test->id, []) }}
                @endif
                <div class="form-group">
                    {{Form::label('question_id', 'Вопрос:')}}
                    {{Form::select('question_id', $selectQuestions,null, ['class' => 'form-control'])}}
                    <small class="form-text text-muted"></small>
                </div>
                <button type="submit" class="btn btn-primary">Привязать</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
