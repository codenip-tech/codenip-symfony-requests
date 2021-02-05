<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\RegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterAction
{
    /**
     * @Route("/register", methods={"POST"}, name="register")
     */
    public function __invoke(RegisterRequest $registerRequest): JsonResponse
    {
        return new JsonResponse();
    }
}
