<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response
    {
        $user = $request->user();
        $token = $user->createToken('api-token');

        Cookie::queue('api-token', $token->plainTextToken, 60 * 24 * 30, null, null, false, false, 'none');

        return Inertia::render('Dashboard');
    }
}
