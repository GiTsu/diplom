<?php

namespace App\Widgets;

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
    ];

    public function run()
    {
        // заполнить опции
        $this->config = $this->mergeModalWidgetOptions('widgets.add_question_item', $this->config);
        // custom logic

        // render content
        return $this->renderModalWidgetContent($this->config);
    }
}
