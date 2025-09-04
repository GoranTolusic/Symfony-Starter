<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\UpdateProfileDto;
use App\Service\User\UpdateUserService;

//For accessing user endpoints, user needs to be authenticated (Authorization header is required on requests)
class UpdateUserController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private UpdateUserService $userService;
    private ValidatorInterface $validator;

    public function __construct(UpdateUserService $userService, ValidatorInterface $validator)
    {
        $this->userService = $userService;
        $this->validator = $validator;
    }

    #[Route('/user/updateMyProfile', name: 'user_updateMyProfile', methods: ['PUT'])]
    public function updateMyProfile(Request $request): JsonResponse
    {
        $loggedUserId = $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, UpdateProfileDto::class, $this->validator);
        return $this->json(['data' => ($this->userService)($dto, $loggedUserId)]);
    }
}
