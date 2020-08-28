<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $admin = new Admin;
        $admin->setUsername($faker->name)
            ->setEmail($faker->email)
            ->setRoles(["ROLE_ADMIN"])
        ;

        $password = $this->encoder->encodePassword($admin, '1');
        $admin->setPassword($password);

        $manager->persist($admin);
        $manager->flush();
    }
}
