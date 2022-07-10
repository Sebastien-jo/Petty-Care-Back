<?php

namespace App\Manager;

use App\Entity\Media;
use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ShopManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function updateShop(Shop $shop, Request $request)
    {
        $file = $request->files->get('file');

        if($file !== null) {
            $media = new Media();
            $media->setFile($file);
            $shop->setMedia($media);
        }

        $this->entityManager->persist($shop);
        $this->entityManager->flush();
    }
}
