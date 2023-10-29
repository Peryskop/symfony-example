<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\AppUserInterface;
use App\Entity\PostInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PostVoter extends Voter
{
    public const DELETE = 'delete';

    public const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        if (! in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        if (! $subject instanceof PostInterface) {
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

        /** @var PostInterface $post */
        $post = $subject;

        return match ($attribute) {
            self::DELETE => $this->canDelete($post, $user),
            self::EDIT => $this->canEdit($post, $user),
            default => throw new \Exception('Voter exception', 500)
        };
    }

    private function canDelete(PostInterface $post, AppUserInterface $user): bool
    {
        return $post->isOwner($user);
    }

    private function canEdit(PostInterface $post, AppUserInterface $user): bool
    {
        return $post->isOwner($user);
    }
}
