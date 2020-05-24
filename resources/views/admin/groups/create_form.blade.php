<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => 'groups.store'])}}
                <div class="form-group">
                    {{Form::label('title', 'Название группы')}}
                    {{Form::text('title', '', ['class' => 'form-control'])}}
                    <small class="form-text text-muted">отображается в списках</small>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
