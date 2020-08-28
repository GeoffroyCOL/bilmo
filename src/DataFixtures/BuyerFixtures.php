<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Buyer;
use App\DataFixtures\CustomerFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BuyerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0; $i < 9; $i++) {
            $buyer = new Buyer;
            $buyer->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setLastname($faker->lastName)
            ;

            $this->addReference('buyer_'.$i, $buyer);
            $manager->persist($buyer);
        }
        $manager->flush();
    }
}
