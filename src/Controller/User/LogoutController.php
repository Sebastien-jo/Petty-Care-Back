<?php

namespace App\Controller\User;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route(path: 'api/logout', name: 'app_logout')]
    public function logout()
    {
    }
}
