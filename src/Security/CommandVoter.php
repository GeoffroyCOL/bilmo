<?php

/**
 * Allows a customer to read or delete his command
 */

namespace App\Security;

use App\Entity\Admin;
use App\Entity\Command;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandVoter extends Voter
{
    const COMMAND = [
        "READ_COMMAND",
        "REMOVE_COMMAND"
    ];
    
    /**
     * supports
     *
     * @param  string $attribute
     * @param  Command $subject
     * @return bool
     */
    public function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, self::COMMAND) && $subject instanceof Command;
    }
    
    /**
     * voteOnAttribute
     *
     * @param  string $attribute
     * @param  Command $subject
     * @param  TokenInterface $token
     */
    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if ($subject->getCustomer() === $user || $user instanceof Customer) {
            return $subject;
        }
    }
}
