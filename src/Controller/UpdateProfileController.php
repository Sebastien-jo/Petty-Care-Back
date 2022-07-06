<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateProfileController extends AbstractController
{
    public function __construct(protected UserManager $userManager)
    {
    }

    public function __invoke($data): JsonResponse
    {
        $this->userManager->onUpdate($data);

        return $this->json($data, 201, ['message' => 'User updated']);
    }
}
