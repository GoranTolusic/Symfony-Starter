<?php

namespace App\Service\Auth;

use App\Repository\UserRepository;
use App\Service\JwtService;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginService
{
    private JwtService $jwt;
    private NativePasswordHasher $hasher;
    private UserRepository $userRepo;

    public function __construct(JwtService $jwt, UserRepository $userRepo)
    {
        $this->jwt = $jwt;
        $this->hasher = new NativePasswordHasher();
        $this->userRepo = $userRepo;
    }

    public function __invoke($dto): array
    {
        //1. Fetch user, throw error if not exists
        //2. Compare passwords, throw error if not matching
        //3. Generate and return id and jwt token to controller

        $user = $this->userRepo->findOneByEmail($dto->email);
        if (!$user || !$this->hasher->verify($user->getPassword(), $dto->password))
            throw new HttpException(401, 'Invalid Credentials');
        return [
            'id' => $user->id,
            'token' => $this->jwt->generateToken(['id' => $user->id])
        ];
    }
}
