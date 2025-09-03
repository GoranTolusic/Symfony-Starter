<?php

namespace App\Service\User;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetUserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($id, $showTags = false): User
    {
        $user = $this->userRepo->find($id);
        if (!$user) throw new HttpException(404, 'User Not Found');
        #HINT: In my opinion very bad for real case scenarios, because of potential fetching large number of records
        #It's just better to use custom queries from repos for specific use cases
        #This one is just for demonstration purposes of using relation features in doctrine entities
        if ($showTags) $user->user_tags = $user->getTags()->map(fn($tag) => [
            'id' => $tag->id,
            'label' => $tag->label
        ])->toArray();

        return $user;
    }
}
