<?php

namespace App\Modules\Auth\Signup\Services;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\User\Add\UserRequest;
use App\Modules\V1\User\Bo\Add\UserDetailsBO;
use App\Repositories\DAO\V1\UserDAO;
use App\Repositories\DAO\V1\UserOTPVerificationDAO;
use App\Repositories\V1\UserRepository;
use Exception;

class SignupService
{

    public function __construct(private UserDetailsBO $userDetailsBo, private UserDAO $userDAO, private UserRepository $userRepository, private UserOTPVerificationDAO $userOTPVerificationDAO)
    {
    }
    public function add(UserDetailsBO $userDetailsBo)
    {
        try {
            $user = $this->insert();
            return $this->verifyOTP($user);
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(UserRequest $userRequest): UserDetailsBO
    {
        $this->userDetailsBo->setName($userRequest->input('name'));
        $this->userDetailsBo->setEmail($userRequest->input('email'));
        $this->userDetailsBo->setPassword($userRequest->input('password'));

        return $this->userDetailsBo;
    }
    public function prepareDAO(): UserDAO
    {
        $this->userDAO->setName($this->userDetailsBo->getName());
        $this->userDAO->setEmail($this->userDetailsBo->getEmail());
        $this->userDAO->setPassword($this->userDetailsBo->getPassword());

        return $this->userDAO;
    }

    private function insert()
    {
        $this->prepareDAO();

        return ['status' => CommonConstant::SUCCESS, 'message' => 'OTP Sent successfully', 'user_id' => $this->userRepository->insert($this->userDAO)]
            ?: throw new Exception(CommonConstant::ERROR_MESSAGE_INSERT_DATA);
    }

    private function verifyOTP($user)
    {
        $otpService = app(OtpService::class);
        return $otpService->sendOtp($user['user_id']);
    }

    public function prepareUserVerificationDAO(): UserOTPVerificationDAO
    {
        $this->userOTPVerificationDAO->setUserId($this->userDetailsBo->getName());
        $this->userOTPVerificationDAO->setOtp($this->userDetailsBo->getEmail());
        $this->userOTPVerificationDAO->setExpiresAt($this->userDetailsBo->getPassword());

        return $this->userOTPVerificationDAO;
    }
}