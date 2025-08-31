<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\JwtService;

class AuthService
{
    private EntityManagerInterface $em;
    private JwtService $jwt;

    public function __construct(EntityManagerInterface $em, JwtService $jwt)
    {
        $this->em = $em;
        $this->jwt = $jwt;
    }

    public function register($data)
    {
        //1. Check if user already exists with same email
        //2. create record
        //3. Simulate send email using symfony messenger (something like verificate email or similar). this can't be blocking operation
        //3. return user record to controller
        return $data;
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
