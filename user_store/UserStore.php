<?php

namespace UserStore;


class UserStore
{
    private array $users;

    public function __construct()
    {
        $this->users = [
            'bob@gmail.com' => [
                'pass'  => $this->passwordHash('12345'),
                'email' => 'bob@gmail.com',
                'name'  => 'Bob'
            ],
            'john@gmail.com' => [
                'pass'  => $this->passwordHash('12345'),
                'email' => 'john@gmail.com',
                'name'  => 'John'
            ],
        ];
    }

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
            'pass' => $this->passwordHash('12345'),
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


    public function passwordHash(string $pass): string
    {
        return md5($pass);
    }


}