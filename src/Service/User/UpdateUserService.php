<?php

namespace App\Service\User;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateUserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($dto, $id): User
    {
        //1. Check if record exists in db, if not throw 404
        //2. Map dto data to user model
        //3. Save changes to db and return results to controller

        $user = $this->userRepo->find($id);
        if (!$user) throw new HttpException(404, 'User Not Found');
        $updatedUser = $dto->toEntity($user);
        return $this->userRepo->save($updatedUser);
    }
}
