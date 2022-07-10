<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/** @Vich\Uploadable() */
#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
      'get' => [
          'method' => 'get',
          'path' => '/media/{id}'
      ]
    ],
    normalizationContext: ['groups' => ['read:media']],
)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:media'])]
    private $file_path;

    /**
     * @return File|null
     * @Vich\UploadableField(mapping="media", fileNameProperty="file_path")
     */
    #[Groups(['write:pet'])]
    private $file;

    /** @var string|null */
    private $fileUrl;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @param string|null $fileUrl
     */
    public function setFileUrl(?string $fileUrl): void
    {
        $this->fileUrl = $fileUrl;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }
}
