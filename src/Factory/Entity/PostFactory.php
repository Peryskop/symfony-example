<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Checker\UserChecker;
use App\DTO\DTOInterface;
use App\DTO\Post\PostDTO;
use App\Entity\Post;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class PostFactory implements EntityFactoryInterface
{
    public function __construct(
        private Security $security
    ) {
    }

    /** @param PostDTO $DTO */
    public function create(DTOInterface $DTO): Post
    {
        $post = new Post();

        $post->setDescription($DTO->description);
        $post->setUser(UserChecker::check($this->security->getUser()));

        return $post;
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === PostDTO::class;
    }
}
