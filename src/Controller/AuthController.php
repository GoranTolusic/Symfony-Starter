<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\RequestValidationTrait;
use App\Dto\RegisterDto;

class AuthController extends AbstractController
{
    use RequestValidationTrait;

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
        //TODO: validate requests
        //$dto = json_decode($request->getContent(), true);
        $created = $this->authService->register($dto);

        return $this->json([
            'status' => 'success',
            'users' => $created
        ]);
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        //TODO: validate requests
        $data = json_decode($request->getContent(), true);
        $token = $this->authService->login($data);

        return $this->json([
            'status' => 'success',
            'token' => $token
        ]);
    }
}
