<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Service\JwtService;

trait MiddlewareTrait
{
    public function authenticateUser(Request $request)
    {
        $token = $request->headers->get('Authorization');
        if (!$token) throw new HttpException(401, 'Missing Authorization token');

        $validatedToken = JwtService::validateStatic($token);
        if (!$validatedToken || !$validatedToken['id']) throw new HttpException(401, 'Invalid or expired Authorization token');
        return $validatedToken['id'];
    }
}
