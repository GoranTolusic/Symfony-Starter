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
        #HINT: In my opinion very bad for real case scenarios, because of potential fetching large number of records
        #It's just better to use custom queries from repos for specific use cases
        #This one is just for demonstration purposes of using relation features in doctrine entities
        $user->user_tags = $user->getTags()->map(fn($tag) => [
            'id' => $tag->id,
            'label' => $tag->label
        ])->toArray();
        
        return $user;
    }

    public function filter($dto): array
    {
        return $this->userRepo->filter($dto->term, $dto->limit, $dto->page);
    }

    public function updateMyProfile($dto, $id): User
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
