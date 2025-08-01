<?php

namespace App\Modules\Auth\Signup\Services;

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
            return ['status' => 'success', 'message' => 'Welcome ' . $user->name, 'token' => $token];
        } catch (Exception | \Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
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
        $user = $this->userRepository->findByEmailAndPassword($email, $password);
        if (!$user) {
            throw new Exception('User not found');
        }
        return $user;
    }

    private function generateJWT($user): string
    {
        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        return JwtService::generateToken($payload, 3600);
    }
}