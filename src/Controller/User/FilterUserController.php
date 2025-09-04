<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\FilterUserDto;
use App\Service\User\FilterUserService;

//For accessing user endpoints, user needs to be authenticated (Authorization header is required on requests)
class FilterUserController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private FilterUserService $userService;

    public function __construct(FilterUserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/user/filter', name: 'user_filter', methods: ['POST'])]
    public function filter(Request $request): JsonResponse
    {
        $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, FilterUserDto::class);
        return $this->json(['data' => ($this->userService)($dto)]);
    }
}
