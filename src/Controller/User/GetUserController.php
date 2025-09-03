<?php

namespace App\Controller\User;

use App\Service\User\GetUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\MiddlewareTrait;

class GetUserController extends AbstractController
{
    use MiddlewareTrait;

    private GetUserService $userService;
    private ValidatorInterface $validator;

    public function __construct(GetUserService $userService, ValidatorInterface $validator)
    {
        $this->userService = $userService;
        $this->validator = $validator;
    }

    #[Route('/user/{id}', name: 'user_myProfile', methods: ['GET'])]
    public function getOneUser(Request $request, int $id): JsonResponse
    {
        $this->authenticateUser($request);
        return $this->json(['data' => ($this->userService)($id, $request->query->get('showTags', false))]);
    }
}
