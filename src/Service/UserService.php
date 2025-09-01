<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getOneUser($id): User
    {
        $user = $this->userRepo->find($id);
        if (!$user) throw new HttpException(404, 'User Not Found');
        return $user;
    }

    public function filter($dto): array
    {
        return $this->userRepo->filter($dto->term, $dto->limit, $dto->page);
    }
}
