<?php

namespace UserStore;


class UserStore
{
    private array $users = [];

    public function addUser(string $name, string $email, string $pass): bool
    {
        if (isset($this->users[$email])) {
            throw new \Exception ("Пользователь {$email} уже зарегистрирован.");
        }
        if (strlen($pass) < 5) {
            throw new \Exception ("Длина пароля должна быть не менее 5 символов.");
        }
        // set user
        $this->users[$email] = [
            'pass' => $pass,
            'email' => $email,
            'name' => $name
        ];

        return true;
    }


    public function getUser(string $email): ?array
    {
        if (!empty($user = $this->users[$email])) {
            return $user;
        }
        return null;
    }


    public function notifyPasswordFailure(string $email): void
    {
        if ( isset($this->users[$email]) ) {
            $this->users[$email]['failed'] = time();
        }
    }


}