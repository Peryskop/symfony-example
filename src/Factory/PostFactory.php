<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Post\PostDTO;
use App\Entity\Post;

final class PostFactory
{
    public function createFromDTO(PostDTO $postDTO): Post
    {
        $post = new Post();

        $post->setDescription($postDTO->description);

        return $post;
    }
}
