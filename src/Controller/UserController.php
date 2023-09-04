<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\Checker\UserChecker;
use App\DTO\Transformer\UserResponseDTOTransformer;
use App\DTO\User\UserDTO;
use App\Repository\UserRepository;
use App\Updater\UserUpdater;
use App\Validator\MultiFieldValidator;
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
        private readonly UserResponseDTOTransformer $userResponseDTOTransformer,
        private readonly UserRepository $userRepository,
        private readonly UserUpdater $userUpdater,
        private readonly MultiFieldValidator $multiFieldValidator
    ) {
        parent::__construct($serializer);
    }

    #[Route('users/current', name: 'get_current', methods: ['GET'])]
    public function getCurrent(): Response
    {
        $user = UserChecker::check($this->security->getUser());

        return $this->respond(
            $this->userResponseDTOTransformer->transformFromObject($user),
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

        $this->userUpdater->update($user, $userDTO);
        $this->userRepository->save($user);

        return $this->respond(
            $this->userResponseDTOTransformer->transformFromObject($user),
            [
                'user:read',
            ]
        );
    }
}
