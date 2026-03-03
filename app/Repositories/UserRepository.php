<?php

namespace App\Repositories;

use App\Models\User;
use App\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUser()
    {
        return User::all();
    }
    public function getUserById($id)
    {
        return User::find($id);
    }
}
