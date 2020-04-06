{{--вывод зарегистрированных переменных--}}
{{--dd(get_defined_vars()['__data'])--}}
<!-- Button trigger modal -->

<button type="button" class="{{$buttonClass}}" data-toggle="modal" data-target="#dt_{{$formId}}">
    {{$buttonTitle ?? 'Заголовок кнопки'}}
</button>
@push('modalDen')
    {{--
    `trouble: backdrop закрывает экран, работает некорректно с z-слоями,
    `solution: нужно прееместить вывод модалки выше по dom-дереву
    --}}
    <div id="dt_{{$formId}}" class="modal fade bd-example-modal-lg " data-backdrop="true" tabindex="-1" role="dialog"
         aria-labelledby="dt_{{$formId}}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mt_{{$formId}}">
                        {{$modalTitle ?? 'Заголовок модалки'}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include($includeView)
                </div>
                <div class="modal-footer">
                    {{--
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    --}}
                </div>
            </div>
        </div>
    </div>
@endpush
