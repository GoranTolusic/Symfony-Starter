<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;


class test{
    public $username;
    public $age;

    public function __construct($username, $age)
    {
        $this->username = $username;
        $this->age = $age;
    }

    static function getInstance($username, $age)
    {
        return new self($username, $age);
    }
}

class ApiController extends AbstractController
{
    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $em): JsonResponse
    {
        // Dohvati repository za User
        $userRepository = $em->getRepository(User::class);

        // Povuci sve korisnike iz baze
        $users = $userRepository->findAll();

        // Pretvori ih u array za JSON
        $data = array_map(function(User $user) {
            return [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName()
            ];
        }, $users);

        return $this->json([
            'status' => 'success',
            'users' => $data
        ]);
    }

    #[Route('/api/hello', name: 'api_hello', methods: ['GET'])]
    public function hello(): JsonResponse
    {
        $test = test::getInstance('goran', '39');

        return $this->json([
            'message' => 'Hello API!',
            'status' => 'success',
            'multi' => [
                'data1' => $test->username,
                'data2' => $test->age
            ]
        ]);
    }

    #[Route('/api/test', name: 'api_test', methods: ['POST'])]
    public function test(Request $request, LoggerInterface $logger): JsonResponse
    {
        // 1. Dohvati query parametre (GET parametri)
        $page = $request->query->get('page', 1); // default = 1
        //$logger->info('Debug data', ['page' => $page]);
        error_log("PAGE");
        error_log($page);
        error_log($request->headers);
        dd(getallheaders()['Content-Length']);


        // 2. Dohvati podatke iz JSON body-a
        $data = json_decode($request->getContent(), true);
        $username = $data['username'] ?? null;

        // 3. Dohvati header
        $auth = $request->headers->get('Authorization');

        // 4. Standardni POST parametri (application/x-www-form-urlencoded)
        $password = $request->request->get('password');

        return new JsonResponse([
            'page' => $page,
            'username' => $username,
            'password' => $password,
            'auth_header' => $auth,
        ]);
    }
}
