<?php

namespace App\Security\Voter;

use App\Entity\PhoneBook;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PhoneBookVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // only vote on `PhoneBook` objects
        if (!$subject instanceof PhoneBook) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'CAN_EDIT':
                foreach($user->getPhoneBook() as $item){
                    if($item->getId() == $subject->getId()){
                        return true;
                    }
                }
                break;
        }

        return false;
    }
}
