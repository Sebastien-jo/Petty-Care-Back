<?php

namespace App\Controller;

use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatePetController extends AbstractController
{

    public function __construct(protected PetManager $petManager)
    {
    }

    public function __invoke($data): JsonResponse
    {
        $this->petManager->createPet($data);

        return $this->json([$data, 201, ['message' => 'Pet created']]);
    }
}
