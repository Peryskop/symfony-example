<?php

declare(strict_types=1);

namespace App\Entity;

interface CommentInterface extends EntityInterface
{
    public function getId(): int;

    public function getContent(): string;

    public function setContent(string $content): void;

    public function getUser(): AppUserInterface;

    public function setUser(User $user): void;

    public function getPost(): PostInterface;

    public function setPost(Post $post): void;

    public function getComment(): ?CommentInterface;

    public function setComment(?Comment $comment): void;

    public function getCreatedAt(): \DateTimeImmutable;

    public function getUpdatedAt(): \DateTimeImmutable;

    public function updateTimestamps(): void;
}
