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
        if (!$token || !JwtService::validateStatic($token))
            throw new HttpException(401, 'Missing, invalid or expired Authorization token');
    }
}
