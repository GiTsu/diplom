<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.01.19
 * Time: 11:03
 */

namespace App\Services;

use App\Models\Role;
use App\Models\Test;
use App\Services\Traits\ServiceCountersTrait;
use App\Services\Traits\ServiceErrorsTrait;
use App\Services\Traits\ServiceSuccessTrait;
use App\User;


class UserService
{
    use ServiceErrorsTrait;
    use ServiceCountersTrait;
    use ServiceSuccessTrait;

    public function __construct()
    {

    }

    /**
     * Создать
     *
     * @param $email
     * @param $password
     * @param array $dops
     * @return User|null
     */
    public function createNewUser($email, $password, array $dops = []): ?User
    {
        if ($this->validateByService([
            'email' => $email,
            'password' => $password
        ], [
            'email' => ['required', 'email'],
            'password' => 'required',
        ])) {
            // создать
            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                $this->addServiceError('Такой пользователь уже существует, используйте восстановление пароля');
                return null;
            }

            unset($old_user);

            $user = new User;
            $user->fill([
                'name' => $dops['name'] ?? $email,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            if ($user->save()) {
                return $user;
            }
            $this->addServiceError('Не удалось сохранить запись');
        }
        return null;
    }

    /**
     * Апдейт редактируемых полей учетки пользователя
     *
     * @param User $user
     * @param array $fields
     *
     * @return bool
     */
    public function updateUser(User $user, array $fields): bool
    {
        if ($this->validateByService($fields, [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ])) {
            $user->fill($fields);
            if ($user->save()) {
                return true;
            }
        }
        return false;
    }

    public function destroyUser(User $user)
    {
        // TODO: внедрить проверки и подчистку базы
        if (!$user->hasRole('admin')) {
            return $user->delete();
        }
        $this->addServiceError('Нельзя удалить аккаунт с правами администратора');
        return false;
    }

    /**
     * Привязать роль по ее ID
     *
     * @param User $user
     * @param $roleId
     * @return bool
     */
    public function addUserRoleById(User $user, $roleId): bool
    {
        $role = Role::find($roleId);
        if ($role) {
            $roles = $user->getRoles();
            // новый код проверки
            if ($roles) {
                $this->addServiceError('У пользователя уже есть роль, сначала удалите ее', ['role' => $roles]);
                return false;
            }
            // новый код проверки
            return $this->addUserRoleBySlug($user, $role->slug);
        }
        $this->addServiceError('Не найдена роль с таким ID', ['role_id' => $roleId]);
        return false;
    }

    /**
     * Добавить пользователю роль
     *
     * @param User $user
     * @param $slug
     * @return bool
     */
    public function addUserRoleBySlug(User $user, $slug): bool
    {
        // TODO проверки на существование и прикрепленность роли
        $roleItem = Role::where([['slug', $slug]])->first();
        if (!$roleItem) {
            $this->addServiceError('Не найдена роль с таким слагом', ['slug' => $slug]);
            return false;
        }
        if ($user->hasRole($roleItem->slug)) {
            $this->addServiceError('Роль уже добавлена');
            return false;
        }
        $user->assignRole($slug);

        //Log::channel('adminActions')->info('пользователю добавлена роль', ['user_id' => $user->id, 'slug' => $slug]);
        return true;
    }

    public function removeUserRoleById(User $user, $roleId): bool
    {
        $roleItem = Role::find($roleId);
        if ($roleItem) {
            return $this->removeUserRoleBySlug($user, $roleItem->slug);
        }
        $this->addServiceError('Не найдена роль с таким id', ['id' => $roleId]);
        return false;
    }

    public function removeUserRoleBySlug(User $user, $slug): bool
    {
        if ($user->hasRole($slug)) {
            return $user->revokeRole($slug);
        }
        $this->addServiceError('У пользователя нет такой роли', ['role' => $slug]);
        return false;
    }

    /**
     * Задание пароля пользователю
     *
     * @param User $user
     * @param $password
     * @return bool
     */
    public function setConfirmedPassword(User $user, $password): bool
    {
        $user->password = bcrypt($password);
        if ($user->save()) {
            return true;
        }
        return false;
    }

    public function assignTest(User $user, $testId): bool
    {
        $test = Test::find($testId);
        if (!$test) {
            $this->addServiceError('Не найден такой тест', ['id' => $testId]);
            return false;
        }

        $hasItem = $user->tests->search(function ($item, $key) use ($testId) {
            return $item->id = $testId;
        });


        if ($hasItem) {
            $this->addServiceError('Этот тест уже добавлен');
            return false;
        }
        $user->tests()->attach($test);

        //Log::channel('adminActions')->info('пользователю добавлена роль', ['user_id' => $user->id, 'slug' => $slug]);
        return true;
    }

}
