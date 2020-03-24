<?php


namespace App\Services\Traits;

// TODO: засунуть автоматическое логирование adminActions, с ключом записи в логи в .env?
trait ServiceSuccessTrait
{
    private $_successMessages = [];

    /**
     * Добавление сообщения об успешном действии.
     *
     * @param $message
     * @param array $context
     */
    public function addSuccessMessage($message, $context = [])
    {
        $this->_successMessages[] = $message;
        return true;
    }

    /**
     * Получить текущие ошибки и обнулить их
     *
     * @return bool
     */
    public function getServiceSuccessString($format = null)
    {
        $messages = $this->getServiceSuccessMessages();
        if ($messages) {
            return implode(' ', $messages);
        }
        return '';
    }


    /**
     * Получить текущие ошибки и обнулить их. Обнуление нужно для батч-скриптов, обходящих коллекции
     * @return array
     */
    public function getServiceSuccessMessages()
    {
        $currentMessages = (!empty($this->_successMessages)) ? $this->_successMessages : [];
        $this->_successMessages = [];
        return $currentMessages;
    }
}