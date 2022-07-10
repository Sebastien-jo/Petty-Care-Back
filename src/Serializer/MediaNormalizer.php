<?php

namespace App\Serializer;

use App\Entity\Media;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class MediaNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'AppMediaNormalizerAlreadyCalled';

    public function __construct(private StorageInterface $storage)
    {
    }

    /**
     * @throws ExceptionInterface
     * @var Media $object
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {

        $object->setFilePath($this->storage->resolveUri($object, 'file'));
        $context[self::ALREADY_CALLED] = true;
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof Media;
    }
}
