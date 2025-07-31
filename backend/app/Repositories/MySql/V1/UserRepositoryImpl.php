<?php

namespace App\Repositories\MySql\V1;

use App\Models\User;
use App\Repositories\DAO\V1\UserDAO;
use App\Repositories\V1\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    public function insert(UserDAO $userDAO): User
    {
        return User::create($userDAO->toArray());
    }
}