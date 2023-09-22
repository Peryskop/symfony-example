<?php

declare(strict_types=1);

namespace App\Factory;

use App\Checker\UserChecker;
use App\DTO\Post\PostDTO;
use App\Entity\Post;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class PostFactory
{
    public function __construct(
        private Security $security
    ) {
    }

    public function createFromDTO(PostDTO $postDTO): Post
    {
        $post = new Post();

        $post->setDescription($postDTO->description);
        $post->setUser(UserChecker::check($this->security->getUser()));

        return $post;
    }
}
