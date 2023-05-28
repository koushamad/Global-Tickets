<?php

namespace App\Service;

use App\Models\User;
use App\Service\Contract\UserServiceContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService implements UserServiceContract
{
    /**
     * Return user with short links
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUserWithShotLinks(int $id): User
    {
        /** @var User $user */
        $user = User::query()->with(['shortLinks'])->findOrFail($id);
        return $user;
    }
}
