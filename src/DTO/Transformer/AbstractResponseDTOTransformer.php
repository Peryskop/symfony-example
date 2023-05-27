<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

abstract class AbstractResponseDTOTransformer implements ResponseDTOTransformerInterface
{
    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }

        return $dto;
    }
}
