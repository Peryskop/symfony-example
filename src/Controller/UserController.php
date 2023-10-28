<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\Checker\UserChecker;
use App\DTO\Transformer\ResponseDTOTransformerInterface;
use App\DTO\User\UserDTO;
use App\Repository\UserRepositoryInterface;
use App\Updater\Entity\CompositeEntityUpdaterInterface;
use App\Validator\MultiFieldValidatorInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'user_')]
final class UserController extends AbstractApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly Security $security,
        private readonly ResponseDTOTransformerInterface $responseDTOTransformer,
        private readonly UserRepositoryInterface $userRepository,
        private readonly CompositeEntityUpdaterInterface $updater,
        private readonly MultiFieldValidatorInterface $multiFieldValidator
    ) {
        parent::__construct($serializer);
    }

    #[Route('users/current', name: 'get_current', methods: ['GET'])]
    public function getCurrent(): Response
    {
        $user = UserChecker::check($this->security->getUser());

        return $this->respond(
            $this->responseDTOTransformer->transformFromObject($user),
            [
                'user:read',
            ]
        );
    }

    #[Route('users/current', name: 'update_current', methods: ['PATCH'])]
    public function updateCurrent(#[MapToDTO] UserDTO $userDTO): Response
    {
        $this->multiFieldValidator->validate($userDTO, ['update']);

        $user = UserChecker::check($this->security->getUser());

        $this->updater->update($user, $userDTO);
        $this->userRepository->save($user);

        return $this->respond(
            $this->responseDTOTransformer->transformFromObject($user),
            [
                'user:read',
            ]
        );
    }
}
