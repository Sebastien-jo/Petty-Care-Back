<?php

namespace App\Controller\Shop;

use App\Manager\ShopManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UpdateShopController extends AbstractController
{
    public function __construct(protected ShopManager $shopManager)
    {
    }

    public function __invoke($data, Request $request)
    {
        $this->shopManager->updateShop($data, $request);

        return $this->json($data, 201, ['message' => 'Shop updated']);
    }
}
