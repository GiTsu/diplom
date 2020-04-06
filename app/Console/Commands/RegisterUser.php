<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register {user} {password} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление пользователя';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userService = new UserService();
        $user = $userService->createNewUser($this->argument('user'), $this->argument('password'));
        if ($user !== null) {
            $role = $this->option('role');
            if ($role) { // try assign new role
                $userService->addUserRoleBySlug($user, $role);
            }
        }
        if ($userService->hasServiceErrors()) {
            $this->info('Возникли ошибки:');
            $this->error($userService->getServiceErrorsString());
        } else {
            $this->info('Пользователь создан успешно');
        }
    }
}
