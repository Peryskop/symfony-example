<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\DTO\User\UserDTO;
use App\Entity\User;
use App\Factory\Entity\CompositeEntityFactoryInterface;
use App\Remover\RefreshTokenRemoverInterface;
use App\Repository\UserRepositoryInterface;
use App\Validator\MultiFieldValidatorInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_')]
final class SecurityController extends AbstractApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly UserRepositoryInterface $userRepository,
        private readonly CompositeEntityFactoryInterface $factory,
        private readonly MultiFieldValidatorInterface $multiFieldValidator,
        private readonly RefreshTokenRemoverInterface $refreshTokenRemover,
    ) {
        parent::__construct($serializer);
    }

    #[Route('register', name: 'register', methods: ['POST'])]
    public function register(#[MapToDTO] UserDTO $userDTO): Response
    {
        $this->multiFieldValidator->validate($userDTO, ['registration']);
        $this->multiFieldValidator->validate($userDTO, ['email']);

        $user = $this->factory->create($userDTO);

        $this->userRepository->save($user);

        return $this->respond(
            [
                'message' => 'User created',
            ],
            [],
            Response::HTTP_CREATED
        );
    }

    #[Route('logout', name: 'logout', methods: ['GET'])]
    public function logout(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->refreshTokenRemover->removeAllUserTokens($user->getUserIdentifier());

        $response = $this->respond(
            [
                'message' => 'Logged out',
            ]
        );

        $response->headers->clearCookie('Bearer');
        $response->headers->clearCookie('refreshToken');

        return $response;
    }
}
