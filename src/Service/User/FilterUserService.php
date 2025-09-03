<?php

namespace App\Service\User;

use App\Repository\UserRepository;

class FilterUserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($dto): array
    {
        return $this->userRepo->filter($dto->term, $dto->limit, $dto->page);
    }

}
