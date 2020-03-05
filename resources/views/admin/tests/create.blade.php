@extends('layouts.admin')
@section('pageTitle', 'Список тестов')
@section('pageSubTitle', 'Подзаголовок')
@section('content')
    <div class=" card">
        <div class="card-body">
            <h5 class="card-title">Новый тест</h5>
            <form class="">

                <div class="position-relative row form-group">
                    <label for="exampleText" class="col-sm-2 col-form-label">Описание теста</label>
                    <div class="col-sm-10">
                        <textarea name="text" id="description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label for="opt_return" class="col-sm-2 col-form-label">Разрешен возврат</label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check">
                            <label class="form-check-label">
                                <input id="opt_return" type="checkbox" class="form-check-input">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label for="opt_skip" class="col-sm-2 col-form-label">Разрешен пропуск</label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check">
                            <label class="form-check-label">
                                <input id="opt_skip" type="checkbox" class="form-check-input">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label for="opt_fullonly" class="col-sm-2 col-form-label">Только полностью</label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check">
                            <label class="form-check-label">
                                <input id="opt_fullonly" type="checkbox" class="form-check-input">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label for="opt_notime" class="col-sm-2 col-form-label">Без ограничений по времени</label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check">
                            <label class="form-check-label">
                                <input id="opt_notime" type="checkbox" class="form-check-input">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label for="opt_timelimit" class="col-sm-2 col-form-label">Длительность теста</label>
                    <div class="col-sm-10">
                        <input name="email" id="opt_timelimit" placeholder="0" type="number" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-check">
                    <div class="col-sm-10 offset-sm-2">
                        <button class="btn btn-secondary">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
