<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\RequestValidationTrait;
use App\Dto\RegisterDto;
use App\Service\Auth\RegisterService;

class RegisterController extends AbstractController
{
    use RequestValidationTrait;

    private RegisterService $authService;

    public function __construct(RegisterService $authService)
    {
        $this->authService = $authService;
    }

    #[Route('/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $dto = $this->validateRequestDto($request, RegisterDto::class);
        return $this->json(['data' => ($this->authService)($dto)]);
    }
}
