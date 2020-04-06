<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                {{Form::open(['route' => ['user.update', $user->id], 'method'=>'PUT'])}}

                <div class="form-group">
                    {{Form::label('title', 'Имя')}}
                    {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                    <small class="form-text text-muted">ФИО</small>
                </div>

                <div class="form-group">
                    {{Form::label('email', 'Имейл')}}
                    {{Form::text('email', $user->email, ['class' => 'form-control'])}}
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
