<?php

namespace App\Widgets;

use App\Widgets\traits\ModalWidgetTrait;
use Arrilot\Widgets\AbstractWidget;

class AddRolePermission extends AbstractWidget
{
    use ModalWidgetTrait;
    /**
     * The configuration array.
     * @var array
     */
    protected $config = [
        'modal' => null,
        'role' => null,
        'permissionArr' => null,
        'buttonTitle' => 'Добавить',
        'modalTitle' => 'Добавление пермишена',
    ];

    public function run()
    {
        // заполнить опции
        $this->config = $this->mergeModalWidgetOptions('widgets.add_role_permission', $this->config);
        // custom logic

        // render content
        return $this->renderModalWidgetContent($this->config);
    }
}
