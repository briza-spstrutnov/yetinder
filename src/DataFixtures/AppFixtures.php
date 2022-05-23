<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // First user
        $user = new User();
        $user->setUsername('Test1');
        $user->setPassword('heslo123');
        $user->setGender('male');
        $user->setHeight(180);
        $user->setWeight(80);
        $user->setPhoneNumber('000 000 000');
        $user->setRating(100);
        $manager->persist($user);

        // Second user
        $user2 = new User();
        $user2->setUsername('Test2');
        $user2->setPassword('heslo123');
        $user2->setGender('female');
        $user2->setHeight(160);
        $user2->setWeight(60);
        $user2->setPhoneNumber('111 111 111');
        $user2->setRating(110);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('Test2');
        $user3->setPassword('heslo123');
        $user3->setGender('female');
        $user3->setHeight(160);
        $user3->setWeight(60);
        $user3->setPhoneNumber('111 111 111');
        $user3->setRating(110);
        $manager->persist($user3);

        $manager->flush();
    }
}
