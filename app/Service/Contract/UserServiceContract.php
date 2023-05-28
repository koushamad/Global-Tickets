<?php

namespace App\Service\Contract;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserServiceContract
{
    /**
     * Return user with short links
     *
     * @throws ModelNotFoundException
     */
    public function getUserWithShotLinks(int $id): User;
}
