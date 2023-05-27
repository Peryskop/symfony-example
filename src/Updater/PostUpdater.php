<?php

declare(strict_types=1);

namespace App\Updater;

use App\DTO\Post\PostDTO;
use App\Entity\Post;

final class PostUpdater
{
    public function update(Post $post, PostDTO $postDTO): void
    {
        $post->setDescription($postDTO->description);
    }
}
