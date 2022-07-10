<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Shop\UpdateShopController;
use App\Repository\ShopRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ApiResource(
    collectionOperations: [
        'items' => [
            'method' => 'get',
            'path' => '/shops'
        ],
        'addItem' => [
            'method' => 'post',
            'path' => '/shops/add',
            'controller' => UpdateShopController::class,
            'openapi_context' => [
                'description' => 'add a new item in your shop',
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'required' => ['name', 'price', 'ref'],
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ],
                                    'name' => [
                                        'type' => 'string'
                                    ],
                                    'stock' => [
                                        'type' => 'integer'
                                    ],
                                    'ref' => [
                                        'type' => 'string'
                                    ],
                                    'price' => [
                                        'type' => 'float'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    itemOperations: [
        'item' => [
            'method' => 'get',
            'path' => '/shops/{id}'
        ],
        'updateItem' => [
            'method' => 'patch',
            'path' => '/shops/{id}/edit',
            'controller' => UpdateShopController::class,
            'openapi_context' => [
                'description' => 'edit information for each item in your shop',
                'requestBody' => [
                    'content' => [
                        'application/x-www-form-urlencoded' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ],
                                    'name' => [
                                        'type' => 'string'
                                    ],
                                    'stock' => [
                                        'type' => 'integer'
                                    ],
                                    'ref' => [
                                        'type' => 'string'
                                    ],
                                    'price' => [
                                        'type' => 'float'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    denormalizationContext: [('update:shop')],
    normalizationContext: [('read:shop')]
)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:shop'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:shop', 'update:shop'])]
    private $name;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:shop', 'update:shop'])]
    private $stock;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:shop', 'update:shop'])]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:shop', 'update:shop'])]
    private $ref;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    #[Groups(['read:shop', 'update:shop'])]
    private $media;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }
}
