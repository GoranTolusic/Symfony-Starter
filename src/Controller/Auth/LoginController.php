<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\RequestValidationTrait;
use App\Dto\LoginDto;
use App\Service\Auth\LoginService;

class LoginController extends AbstractController
{
    use RequestValidationTrait;

    private LoginService $authService;

    public function __construct(LoginService $authService)
    {
        $this->authService = $authService;
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $dto = $this->validateRequestDto($request, LoginDto::class);
        return $this->json(['data' => ($this->authService)($dto)]);
    }
}
