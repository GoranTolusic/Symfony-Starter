<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Service\JwtService;
use App\Message\SendEmailMessage;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;

class AuthService
{
    private EntityManagerInterface $em;
    private JwtService $jwt;
    private NativePasswordHasher $hasher;
    private UserRepository $userRepo;
    private MessageBusInterface $bus;

    public function __construct(EntityManagerInterface $em, JwtService $jwt, UserRepository $userRepo, MessageBusInterface $bus)
    {
        $this->em = $em;
        $this->jwt = $jwt;
        $this->hasher = new NativePasswordHasher();
        $this->userRepo = $userRepo;
        $this->bus = $bus;
    }

    public function register($dto)
    {
        //1. Check if user already exists with same email. If exists, throw 409, if not proceed with logic
        //2. Need to hash password on DTO model
        //3. Convert dto to entity model
        //4. Create record in db
        //5. Send email using symfony messenger queue or something similar which is not going to block further logic
        //6. Send response to client

        $userExists = $this->userRepo->findOneByEmail($dto->email);
        if ($userExists) throw new HttpException(409, 'Email is already in use.');
        $dto->password = $this->hasher->hash($dto->password);
        $entity = $dto->toEntity(new User());
        consoleLog($entity); //A little helper for inspecting variables. Logs are displayed in server console.
        $created = $this->userRepo->save($entity);
        //Simulating sending email for now
        $this->bus->dispatch(new SendEmailMessage(
            $dto->email,
            'Welcome!',
            'Thanks for registering!'
        ));

        return $created;
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
