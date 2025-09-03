<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\FilterUserDto;
use App\Service\User\FilterUserService;

//For accessing user endpoints, user needs to be authenticated (Authorization header is required on requests)
class FilterUserController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private FilterUserService $userService;
    private ValidatorInterface $validator;

    public function __construct(FilterUserService $userService, ValidatorInterface $validator)
    {
        $this->userService = $userService;
        $this->validator = $validator;
    }

    #[Route('/user/filter', name: 'user_filter', methods: ['POST'])]
    public function filter(Request $request): JsonResponse
    {
        $this->authenticateUser($request);
        $dto = $this->validateRequestDto($request, FilterUserDto::class, $this->validator);
        return $this->json(['data' => ($this->userService)($dto)]);
    }
}
