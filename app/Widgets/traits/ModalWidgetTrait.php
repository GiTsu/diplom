<?php

namespace App\Widgets\traits;

use App\Helpers\FormatHelper;

trait ModalWidgetTrait
{
    protected $_mwConfig = [
        'modal' => false,
        'model' => null,
        'route' => '',
        'view' => '',
        'method' => 'post',
        'files' => false,
        'buttonTitle' => 'Заголовок кнопки',
        'buttonClass' => 'btn mr-2 mb-2 btn-primary',
        'modalTitle' => 'Заголовок модалки',
    ];

    public function mergeModalWidgetOptions($view, array $options = [])
    {
        $options = array_merge($this->_mwConfig, $options);
        $options['includeView'] = $view;
        $options['renderView'] = !empty($options['modal']) ? 'widgets.shared.shared_modal' : $options['includeView'];
        $options['formId'] = 'f' . FormatHelper::makeHash();
        return $options;
    }

    public function renderModalWidgetContent(array $options)
    {
        if (!empty($options['renderView']) && view()->exists($options['renderView'])) {
            return view($options['renderView'], $options);
        }
        return 'Неправильный вызов виджета';
    }
}
