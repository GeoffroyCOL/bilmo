<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Command;
use App\DataFixtures\BuyerFixtures;
use App\DataFixtures\PhoneFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0; $i < 9; $i++) {
            $command = new Command;
            
            $command->setBuyer($this->getReference('buyer_'.$i))
                    ->setCustomer($this->getReference('customer_'.$i))
            ;

            $this->addReference('command_'.$i, $command);
            $manager->persist($command);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BuyerFixtures::class,
            CustomerFixtures::class
        );
    }
}
