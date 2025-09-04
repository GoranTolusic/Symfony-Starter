<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\UpdateProfileDto;
use App\Service\User\UpdateUserService;

//For accessing user endpoints, user needs to be authenticated (Authorization header is required on requests)
class UpdateUserController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private UpdateUserService $userService;

    public function __construct(UpdateUserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/user/updateMyProfile', name: 'user_updateMyProfile', methods: ['PUT'])]
    public function updateMyProfile(Request $request): JsonResponse
    {
        $loggedUserId = $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, UpdateProfileDto::class);
        return $this->json(['data' => ($this->userService)($dto, $loggedUserId)]);
    }
}
