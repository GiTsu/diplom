<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.01.19
 * Time: 11:03
 */

namespace App\Services;

use App\Models\Result;
use App\Models\Test;
use App\Services\Traits\ServiceCountersTrait;
use App\Services\Traits\ServiceErrorsTrait;
use App\Services\Traits\ServiceSuccessTrait;
use App\User;


class TestService
{
    use ServiceErrorsTrait;
    use ServiceCountersTrait;
    use ServiceSuccessTrait;

    public function __construct()
    {

    }

    public function canDoTest(User $user, Test $test)
    {
        return true;
    }

    public function getNextQuestion(User $user, Test $test, $lastId = 0)
    {
        // выбрать следующий за последним
        $question = $test->questions()->where('question_id', '>', $lastId)->orderBy('id')->first();

        if ($question) {
            return $question;
        }
        $this->addServiceError('Не найдено вопросов');
        return null;
    }

    public function getUserTestResultRecord(User $user, Test $test)
    {
        // получим или создадим запись со статусом прохождения теста
        $userResult = $user->results()->where('test_id', '=', $test->id)->first();
        if (!$userResult) {
            $userResult = new Result();
            $userResult->fill([
                'test_id' => $test->id,
                'user_id' => $user->id,
            ]);
            $userResult->save();
        }
        return $userResult;
    }
}
