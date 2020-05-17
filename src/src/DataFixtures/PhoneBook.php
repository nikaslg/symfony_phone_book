<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\PhoneBook;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++){
            $entry = new PhoneBook();
            $entry->setName($faker->name);
            $entry->setPhone($faker->phoneNumber);
            $manager->persist($entry);
        }

        $manager->flush();
    }
}