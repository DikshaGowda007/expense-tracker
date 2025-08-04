<?php

namespace App\Modules\Auth\Signup\Services;

use App\Constants\CommonConstant;
use App\Modules\Auth\JwtService;
use App\Modules\V1\User\Bo\Add\UserDetailsBO;
use App\Repositories\DAO\V1\UserDAO;
use App\Repositories\DAO\V1\UserOTPVerificationDAO;
use App\Repositories\V1\UserRepository;
use Exception;

class LoginService
{

    public function __construct(private UserDetailsBO $userDetailsBo, private UserDAO $userDAO, private UserRepository $userRepository, private UserOTPVerificationDAO $userOTPVerificationDAO)
    {
    }

    public function add(string $email, string $password)
    {
        try {
            $user = $this->validateUser($email, $password);
            $token = $this->generateJWT($user);
            return ['status' => CommonConstant::SUCCESS, 'message' => 'Welcome ' . $user->name, 'token' => $token];
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareDAO(): UserDAO
    {
        $this->userDAO->setName($this->userDetailsBo->getName());
        $this->userDAO->setEmail($this->userDetailsBo->getEmail());
        $this->userDAO->setPassword($this->userDetailsBo->getPassword());

        return $this->userDAO;
    }

    private function validateUser($email, $password)
    {
        return $this->userRepository->findByEmailAndPassword($email, $password)
            ?: throw new Exception(CommonConstant::USER_NOT_FOUND);
    }

    private function generateJWT($user): string
    {
        $payload = [
            'loggedin_user_id' => $user->id,
            'loggedin_user_name' => $user->name,
            'loggedin_user_email' => $user->email,
        ];

        return JwtService::generateToken($payload, 3600);
    }
}