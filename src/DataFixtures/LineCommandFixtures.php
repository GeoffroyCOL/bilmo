<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\LineCommand;
use App\DataFixtures\PhoneFixtures;
use App\DataFixtures\CommandFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LineCommandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0; $i < 9; $i++) {
            $lineCommand = new LineCommand;
            
            $lineCommand->setNumber($faker->randomDigit)
                        ->setPhone($this->getReference('phone_'.$i))
                        ->setCommand($this->getReference('command_'.$i))
            ;

            $this->addReference('lineCommand'.$i, $lineCommand);
            $manager->persist($lineCommand);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            PhoneFixtures::class,
            CommandFixtures::class
        );
    }
}
