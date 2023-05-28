<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Service\Contract\UserServiceContract;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {
        $this->middleware(['auth:sanctum']);
    }

    public function __invoke(Request $request): UserResource
    {
        $user = $this->userService->getUserWithShotLinks($request->user()->id);

        return UserResource::make($user);
    }
}
