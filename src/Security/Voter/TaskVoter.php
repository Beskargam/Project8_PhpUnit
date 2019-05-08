<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['EDIT', 'DELETE'])
            && $subject instanceof Task;
    }

    protected function voteOnAttribute($attribute, $task, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getRoles() == ['ROLE_ADMIN', 'ROLE_USER'] && $task->getUser() == null) {
            return true;
        }

        switch ($attribute) {
            case 'EDIT':
                if ($user->getRoles() == ['ROLE_ADMIN', 'ROLE_USER'] or $task->getUser() != null && $task->getUser()->getId() == $user->getId()) {
                    return true;
                }
                break;
            case 'DELETE':
                if ($user->getRoles() == ['ROLE_ADMIN', 'ROLE_USER'] or $task->getUser() != null && $task->getUser()->getId() == $user->getId()) {
                    return true;
                }
                break;
        }

        return false;
    }
}
