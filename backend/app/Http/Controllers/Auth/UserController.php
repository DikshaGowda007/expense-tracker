<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\Add\UserLoginRequest;
use App\Modules\Auth\Signup\Services\LoginService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(UserLoginRequest $userLoginRequest)
    {
        try {
            $email = $userLoginRequest->input('email');
            $password = $userLoginRequest->input('password');
            $loginService = app(LoginService::class);
            $result = $loginService->add($email, $password);
            $response = response()->json($result['data']);

            if (!empty($result['cookie'])) {
                $response->withCookie($result['cookie']);
            }
            return $response;
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    public function logout(Request $request)
    {
        try {
            $cookie = cookie('token', '', -1); // Set expiration in the past

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully',
            ])->withCookie($cookie);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }
}
