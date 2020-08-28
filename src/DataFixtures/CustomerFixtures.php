<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Customer;
use App\DataFixtures\BuyerFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0; $i<9; $i++) {
            $customer = new Customer;
            $customer->setUsername($faker->company)
                ->setEmail($faker->email)
                ->setRoles(["ROLE_CUSTOMER"])
                ->addBuyer($this->getReference('buyer_'.$i))
            ;

            $password = $this->encoder->encodePassword($customer, '1');
            $customer->setPassword($password);

            $this->addReference('customer_'.$i, $customer);
            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BuyerFixtures::class
        );
    }
}
