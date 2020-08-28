<?php

/**
 * Allows a customer to read or delete his buyer
 */

namespace App\Security;

use App\Entity\Admin;
use App\Entity\Buyer;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class BuyerVoter extends Voter
{
    const BUYER = [
        "READ_BUYER",
        "REMOVE_BUYER"
    ];
    
    /**
     * supports
     *
     * @param  string $attribute
     * @param  Buyer $subject
     * @return bool
     */
    public function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, self::BUYER) && $subject instanceof Buyer;
    }
    
    /**
     * voteOnAttribute
     *
     * @param  string $attribute
     * @param  Buyer $subject
     * @param  TokenInterface $token
     */
    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (($user instanceof Admin && $attribute === "READ_BUYER") || $user->getBuyers()->contains($subject)) {
            return $subject;
        }

        if ($user instanceof Admin && $attribute === "REMOVE_BUYER") {
            return false;
        }
    }
}
