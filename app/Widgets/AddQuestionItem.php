<?php

namespace App\Widgets;

use App\Helpers\FormatHelper;
use App\Models\Question;
use App\Widgets\traits\ModalWidgetTrait;
use Arrilot\Widgets\AbstractWidget;

class AddQuestionItem extends AbstractWidget
{
    use ModalWidgetTrait;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'modal' => true,
        'permissionArr' => null,
        'buttonTitle' => 'Добавить ответ',
        'modalTitle' => 'Добавление ответа',
        'question' => null,
    ];

    public function run()
    {
        // заполнить опции
        $this->config = $this->mergeModalWidgetOptions('admin.questionItems.create_form', $this->config);
        // custom logic

        // если не ввод с клавиатуры, то дать создать
        if ($this->config['question']->type_id !== Question::ENTER_QUESTION) {
            // render content
            return $this->renderModalWidgetContent($this->config);
        }
        return 'ввод вариантов ответов не поддерживается';
    }
}
