<?php

namespace App\Widgets;

use App\Widgets\traits\ModalWidgetTrait;
use Arrilot\Widgets\AbstractWidget;

class GenericModalWidget extends AbstractWidget
{
    use ModalWidgetTrait;
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'modal' => null,
        'permissionArr' => null,
        'includeView' => '',
        'buttonTitle' => 'кнопка',
        'modalTitle' => 'заголовоу',
    ];

    public function run()
    {
        $this->config = $this->mergeModalWidgetOptions($this->config['includeView'], $this->config);
        // custom logic

        // render content
        return $this->renderModalWidgetContent($this->config);
    }
}
