<?php

namespace App\DataFixtures;

use Cassandra\Time;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TimeClick;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $morning = new TimeClick();
        $morning->setTime("06:00:00");
        $morning->setClicks(0);
        $morning->setDayTime('morning');
        $morning->setEndTime("11:59:59");

        $manager->persist($morning);

        $afternoon = new TimeClick();
        $afternoon->setTime("12:00:00");
        $afternoon->setClicks(0);
        $afternoon->setDayTime('afternoon');
        $afternoon->setEndTime("17:59:59");

        $manager->persist($afternoon);

        $evening = new TimeClick();
        $evening->setTime("18:00:00");
        $evening->setClicks(0);
        $evening->setDayTime('evening');
        $evening->setEndTime("23:59:59");

        $manager->persist($evening);

        $night = new TimeClick();
        $night->setTime("00:00:00");
        $night->setClicks(0);
        $night->setDayTime('night');
        $night->setEndTime("05:59:59");

        $manager->persist($night);

        $manager->flush();
    }
}
