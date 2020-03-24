<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.03.19
 * Time: 12:20
 */

namespace App\Services\Traits;

use Illuminate\Support\Facades\Log;
use Validator;

// TODO: перенести в папку ../Traits
trait ServiceErrorsTrait
{
    private $serviceErrors = [];

    // todo добавить warning отдельным полем?

    /**
     * Получить текущие ошибки и обнулить их
     *
     * @return bool
     */
    public function getServiceErrorsString()
    {
        $errors = $this->getServiceErrors();
        if ($errors) {
            return implode(' ', $errors);
        }
        return '';
    }


    /**
     * Получить текущие ошибки и обнулить их
     *
     * @return array
     */
    public function getServiceErrors()
    {
        // todo перевести на null
        // а зачем обнулять?..
        $currentErrors = ($this->hasServiceErrors()) ? $this->serviceErrors : [];
        $this->serviceErrors = [];
        return $currentErrors;
    }

    /**
     * Проверка на наличие ошибок
     * @return bool
     */
    public function hasServiceErrors()
    {
        return !empty($this->serviceErrors);
    }

    /**
     * Проверка на отсутствие ошибок
     * @return bool
     */
    public function hasNoServiceErrors()
    {
        return !$this->hasServiceErrors();
    }

    /**
     * Валидация по правилам валидатора с перекачкой ошибок в свой формат.
     * https://laravel.com/docs/5.5/validation
     * @param array $options
     * @param array $rules
     * @return bool
     */
    public function validateByService(array $options, array $rules)
    {
        $validator = Validator::make($options, $rules);

        if ($validator->fails()) {
            // пришли неправильные поля
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $this->addServiceError($message);
            }
            // TODO: решить секьюрно ли сваливать failed userInput в файл
            // $this->addServiceError('Данные ввода не прошли проверку в сервисе', $options);
            return false;
        }
        return true;
    }

    /**
     * Добавление ошибки в список
     *
     * @param $error
     */
    public function addServiceError(string $error, array $context = [], int $code = 0, int $digTrace = 3)
    {
        $this->serviceErrors[] = $error;
//        if (config('app.debug')) { // логировать ошибки в дебаг-режиме
        if (true) { // логируем всегда
            $errorParams[] = 'code:' . $code;
            if ($digTrace) {
                $errorParams[] = 'trace:' . $digTrace;
                $stackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $digTrace);
                // index > 0 - вызов откуда получилась ошибка, 0 - текущий контекст, не интересует
                for ($i = $digTrace - 1; $i > 0; $i--) {
                    $str = '';
                    if (!empty($stackTrace[$i])) {
                        if (!empty($stackTrace[$i]['class'])) {
                            $str = $str . $stackTrace[$i]['class'];
                        }
                        if (!empty($stackTrace[$i]['function'])) {
                            $str = $str . '@' . $stackTrace[$i]['function'];
                        }
                        if (!empty($stackTrace[$i]['line'])) {
                            $str = $str . ':' . $stackTrace[$i]['line'];
                        }
                        $errorParams[] = $str;
                    }
                }
            }
            $errorParams = array_merge($errorParams, $context);
            Log::channel('serviceErrors')->debug($error, $errorParams);
        }
    }

    public function mergeServiceErrors($errors)
    {
        if (is_array($errors)) {
            $this->serviceErrors = array_merge($this->serviceErrors, $errors);
        }
    }

    public function addServiceException(string $title, \Exception $e, array $options = [])
    {
        $options['errorCode'] = $e->getCode();
        $options['errorMessage'] = $e->getMessage();
        $options['errorFile'] = $e->getFile();
        $options['errorLine'] = $e->getLine();
        $this->addServiceError($title);
        Log::critical($title, $options);
    }

}
