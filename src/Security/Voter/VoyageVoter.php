<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Voyage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class VoyageVoter extends Voter
{
    public const EDIT = 'VOYAGE_EDIT';
    public const VIEW = 'VOYAGE_SHOW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Voyage;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
                break;
            case self::VIEW:
                return $this->canView($subject, $user);
                break;
        }

        return false;
    }

    private function canView(Voyage $voyage, User $user): bool
    {
        if ($user->getVoyages()->contains($voyage)) {
            return true;
        }
        return false;
    }

    private function canEdit(Voyage $voyage, User $user): bool
    {
        if ($voyage->getOwner() === $user) {
            return true;
        }
        return false;
    }
}
