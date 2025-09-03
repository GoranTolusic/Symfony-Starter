<?php

namespace App\Service\Auth;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Message\UserRegistered;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;

class RegisterService
{
    private NativePasswordHasher $hasher;
    private UserRepository $userRepo;
    private MessageBusInterface $bus;

    public function __construct(UserRepository $userRepo, MessageBusInterface $bus)
    {
        $this->hasher = new NativePasswordHasher();
        $this->userRepo = $userRepo;
        $this->bus = $bus;
    }

    public function __invoke($dto): object
    {
        //1. Check if user already exists with same email. If exists, throw 409, if not proceed with logic
        //2. Need to hash password on DTO model
        //3. Convert dto to entity model
        //4. Create record in db
        //5. Set response object together with tags
        //7. Send email and notification using symfony messenger queue or something similar which is not going to block further logic
        //8. Send response to client

        $userExists = $this->userRepo->findOneByEmail($dto->email);
        if ($userExists) throw new HttpException(409, 'Email is already in use.');
        $dto->password = $this->hasher->hash($dto->password);
        $entity = $dto->toEntity(new User(), ['tags']);
        $created = $this->userRepo->save($entity, $dto->tags);
        $response = (object) get_object_vars($created);
        $response->tags = $dto->tags;

        //Simulating async sending email for now
        $this->bus->dispatch(new UserRegistered(
            $dto->email,
            'Welcome!',
            'Thanks for registering!'
        ));

        return $response;
    }
}
