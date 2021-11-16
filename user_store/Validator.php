<?php

namespace UserStore;

class Validator
{
    private UserStore $store;

    public function __construct(UserStore $store) {
        $this->store = $store;
    }

    public function validateUser(string $email, string $pass): bool
    {
        $user = [];
        // find User
        if (!is_array($user = $this->store->getUser($email))) {
            return false;
        }
        // check password
        if ($user['pass'] != $pass) {
            $this->store->notifyPasswordFailure($email);
            return false;
        }

        return true;
    }

}