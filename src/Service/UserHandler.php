<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler
{
    private $manager;
    private $encoder;
    private $repository;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, UserRepository $repository)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->repository = $repository;
    }

    /**
     * add
     *
     * @param  User $admin
     * @return User
     */
    public function add(User $user): User
    {
        $this->password($user);
        $this->manager->persist($user);
        $this->manager->flush();

        return $this->getUserWithoutPassword($user);
    }

    /**
     * delete
     *
     * @param  User $user
     */
    public function delete(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }
    
    /**
     * password
     *
     * @param  User $user
     */
    private function password(User $user)
    {
        if ($user->getPlainPassword()) {
            $user->setPassword(
                $this->encoder->encodePassword($user, $user->getPlainPassword())
            );
            $user->eraseCredentials();
        }
    }
    
    /**
     * getUserWithoutPassword - Retrieves a user without password
     *
     * @param  User $user
     * @return User
     */
    private function getUserWithoutPassword(User $user): User
    {
        $user->setPassword('')
                ->setPlainPassword('');

        return $user;
    }
}
