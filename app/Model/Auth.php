<?php

namespace App\Model;



class Auth
{


    public function __construct(
        protected User $user
    ) {}

    public function check()
    {
        return (bool) ($_SESSION['user'] ?? false);
    }


    public function user()
    {

        if (!$this->check()) return null;
        return $this->user->findByUsername($_SESSION['user']);
    }

    public function id()
    {
        return $this->user()['id'] ?? null;
    }

    public function isAdmin()
    {
        if (!$this->check()) return false;

        return $this->user->isAdmin($_SESSION['user']);
    }

    public function avatar()
    {
        return $this->user()['avatar'] ?? null;
    }
}
