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

    public function register(): array
    {
        //$this->jwt->inspectSecret();
        return [];
    }

    public function getAllUsers(): array
    {
        // Dohvati sve korisnike iz baze
        $users = $this->em->getRepository(User::class)->findAll();

        // Pretvori ih u array za JSON
        return array_map(function(User $user) {
            return [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
            ];
        }, $users);
    }
}
