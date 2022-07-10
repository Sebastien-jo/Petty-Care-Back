<?php

namespace App\Controller\Pet;

use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreatePetController extends AbstractController
{

    public function __construct(protected PetManager $petManager)
    {
    }

    public function __invoke($data, Request $request): JsonResponse
    {
        $this->petManager->createPet($data, $request);

        return $this->json([$data, 201, ['message' => 'Pet created']]);
    }
}
