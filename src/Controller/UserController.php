<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\FilterUserDto;
use App\Dto\UpdateProfileDto;

//For accessing user endpoints, user needs to be authenticated (Authorization header is required on requests)
class UserController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private UserService $userService;
    private ValidatorInterface $validator;

    public function __construct(UserService $userService, ValidatorInterface $validator)
    {
        $this->userService = $userService;
        $this->validator = $validator;
    }

    #[Route('/user/{id}', name: 'user_myProfile', methods: ['GET'])]
    public function getOneUser(Request $request, int $id): JsonResponse
    {
        $this->authenticateUser($request);
        return $this->json(['data' => $this->userService->getOneUser($id)]);
    }

    #[Route('/user/filter', name: 'user_filter', methods: ['POST'])]
    public function filter(Request $request): JsonResponse
    {
        $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, FilterUserDto::class, $this->validator);
        return $this->json(['data' => $this->userService->filter($dto)]);
    }

    #[Route('/user/updateMyProfile', name: 'user_updateMyProfile', methods: ['PUT'])]
    public function updateMyProfile(Request $request): JsonResponse
    {
        $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, UpdateProfileDto::class, $this->validator);
        return $this->json(['data' => $dto]);
    }
}
