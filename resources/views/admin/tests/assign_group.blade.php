<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => ['admin:results:assignToGroup', $test->id]])}}

                <div class="form-group">
                    {{Form::label('group_id', 'Группа:')}}
                    {{Form::select('group_id', $groups, null, ['class' => 'form-control'])}}
                    <small class="form-text text-muted"></small>
                </div>
                <button type="submit" class="btn btn-primary">Привязать</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
