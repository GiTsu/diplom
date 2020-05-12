<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => 'questionItems.store'])}}
                @if(!empty($question))
                    {{ Form::hidden('question_id', $question->id, []) }}
                @endif

                @if($question->type_id!=\App\Models\Question::COMPLY_QUESTION)
                    <div class="form-group form-check">
                        {{Form::checkbox('is_correct', 1, null, ['class'=>'form-check-input'])}}
                        {{Form::label('is_correct', 'Правильный ответ', ['class' => 'form-check-label']) }}
                    </div>
                @endif
                <div class="form-group">
                    {{Form::label('text', 'Текст ответа')}}
                    {{Form::textarea('text', '', ['class' => 'form-control'])}}
                    <small class="form-text text-muted">краткое описание</small>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
