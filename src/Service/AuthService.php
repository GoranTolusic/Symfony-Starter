<?php

namespace App\Service;

use App\Entity\User;
use App\Service\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

class AuthService
{
    private EntityManagerInterface $em;
    private JwtService $jwt;
    private NativePasswordHasher $hasher;

    public function __construct(EntityManagerInterface $em, JwtService $jwt)
    {
        $this->em = $em;
        $this->jwt = $jwt;
        $this->hasher = new NativePasswordHasher();
    }

    public function register($dto)
    {
        //1. Check if user already exists with same email. If exists, throw 405 not allowed, if not hash password 

        $dto->password = $this->hasher->hash($dto->password);
        //2. create record
        //3. Simulate send email using symfony messenger (something like verificate email or similar). this can't be blocking operation
        //3. return user record to controller
        return $dto;
    }

    public function login($data): string
    {
        // Fetch user
        $user = $this->em->getRepository(User::class)->findBy(['email' => $data['email']]);
        error_log($user);

        // Pretvori ih u array za JSON
        return 'jwt token';
    }
}
