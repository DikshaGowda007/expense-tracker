<?php

namespace App\Modules\Auth\Signup\Services;

use App\Http\Requests\V1\User\Add\UserRequest;
use App\Modules\V1\User\Bo\Add\UserDetailsBO;
use App\Repositories\DAO\V1\UserDAO;
use App\Repositories\V1\UserRepository;
use Exception;

class SignupService
{

    public function __construct(private UserDetailsBO $userDetailsBo, private UserDAO $userDAO, private UserRepository $userRepository)
    {
    }
    public function add(UserDetailsBO $userDetailsBo)
    {
        try {
            $this->insert();
            return ['status' => 'success', 'message' => 'Account created successfully'];
        } catch (Exception | \Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];

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

        $user = $this->userRepository->insert($this->userDAO);
        if (!$user) {
            throw new Exception('Insert failed');
        }
        return $user;
    }
}