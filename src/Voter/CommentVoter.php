<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\AppUserInterface;
use App\Entity\CommentInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class CommentVoter extends Voter
{
    public const DELETE = 'delete';

    public const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        if (! in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        if (! $subject instanceof CommentInterface) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (! $user instanceof AppUserInterface) {
            return false;
        }

        /** @var CommentInterface $comment */
        $comment = $subject;

        return match ($attribute) {
            self::DELETE => $this->canDelete($comment, $user),
            self::EDIT => $this->canEdit($comment, $user),
            default => throw new \Exception('Voter exception', 500)
        };
    }

    private function canDelete(CommentInterface $comment, AppUserInterface $user): bool
    {
        return $comment->isOwner($user) || $comment->getPost()->isOwner($user);
    }

    private function canEdit(CommentInterface $comment, AppUserInterface $user): bool
    {
        return $comment->isOwner($user);
    }
}
