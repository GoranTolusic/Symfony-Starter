<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\RequestValidationTrait;
use App\Traits\MiddlewareTrait;
use App\Dto\RegisterDto;
use App\Dto\LoginDto;

class AuthController extends AbstractController
{
    use RequestValidationTrait, MiddlewareTrait;

    private AuthService $authService;
    private ValidatorInterface $validator;

    public function __construct(AuthService $authService, ValidatorInterface $validator)
    {
        $this->authService = $authService;
        $this->validator = $validator;
    }

    #[Route('/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $dto = $this->validateRequestDto($request, RegisterDto::class, $this->validator);
        return $this->json(['data' => $this->authService->register($dto)]);
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $dto = $this->validateRequestDto($request, LoginDto::class, $this->validator);
        return $this->json(['data' => $this->authService->login($dto)]);
    }
}
