<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\Add\UserLoginRequest;
use App\Modules\Auth\Signup\Services\LoginService;

class UserController extends Controller
{
    public function login(UserLoginRequest $userLoginRequest)
    {
        try {
            $email = $userLoginRequest->input('email');
            $password = $userLoginRequest->input('password');
            $loginService = app(LoginService::class);
            return response()->json($loginService->add($email, $password));
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }
}
