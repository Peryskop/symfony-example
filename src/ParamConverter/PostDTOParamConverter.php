<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\DTO\Post\PostDTO;
use App\Factory\DTOFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class PostDTOParamConverter implements ParamConverterInterface
{
    public function __construct(
        private DTOFactory $DTOFactory
    ) {
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $name = $configuration->getName();
        $object = $this->DTOFactory->createPostDTOFromRequest($request);

        $request->attributes->set($name, $object);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === PostDTO::class;
    }
}
