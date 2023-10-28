<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Checker\UserChecker;
use App\DTO\Comment\CommentDTO;
use App\DTO\Comment\CommentDTOInterface;
use App\DTO\DTOInterface;
use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Repository\CommentRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CommentFactory implements EntityFactoryInterface
{
    public function __construct(
        private Security $security,
        private PostRepositoryInterface $postRepository,
        private CommentRepositoryInterface $commentRepository,
    ) {
    }

    /** @param CommentDTOInterface $DTO */
    public function create(DTOInterface $DTO): EntityInterface
    {
        $comment = new Comment();

        $comment->setUser(UserChecker::check($this->security->getUser()));
        $comment->setContent($DTO->getContent());
        $comment->setPost($this->postRepository->findById($DTO->getPostId()));
        if ($DTO->getCommentId()) {
            $comment->setComment($this->commentRepository->findById($DTO->getCommentId()));
        }

        return $comment;
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === CommentDTO::class;
    }
}
