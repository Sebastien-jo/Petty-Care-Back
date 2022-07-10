<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogoutController extends AbstractController
{
    public function __construct(protected UserManager $userManager)
    {
    }

    public function __invoke()
    {
        $this->userManager->logout();
    }
}
