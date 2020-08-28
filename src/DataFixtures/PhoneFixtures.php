<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0; $i<50; $i++) {
            $phone = new Phone;
            $phone->setName($faker->word)
                ->setPrice($faker->randomFloat(2, 50, 350))
                ->setImage($faker->imageUrl)
                ->setContent($faker->text(600))
                ->setNumber($faker->randomDigit)
                ->setNumberSold(0)
                ->setActive(true)
            ;

            $this->addReference('phone_'.$i, $phone);
            $manager->persist($phone);
        }

        $manager->flush();
    }
}
