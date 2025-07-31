<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\Add\UserRequest;
use App\Modules\Auth\Signup\Services\SignupService;

class SignupController extends Controller
{
    public function signup(UserRequest $userRequest)
    {
        try {
            $signupService = app(SignupService::class);
            $userDetailsBo = $signupService->prepareBo($userRequest);
            return response()->json($signupService->add($userDetailsBo));
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }
}
