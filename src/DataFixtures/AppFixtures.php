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
        $morning->setTime(strftime("%X",mktime(6,0,0)));
        $morning->setClicks(0);
        $morning->setDayTime('morning');
        $morning->setEndTime(strftime("%X",mktime(11,59,59)));

        $manager->persist($morning);

        $afternoon = new TimeClick();
        $afternoon->setTime(strftime("%X",mktime(12,0,0)));
        $afternoon->setClicks(0);
        $afternoon->setDayTime('afternoon');
        $afternoon->setEndTime(strftime("%X",mktime(17,59,59)));

        $manager->persist($afternoon);

        $evening = new TimeClick();
        $evening->setTime(strftime("%X",mktime(18,0,0)));
        $evening->setClicks(0);
        $evening->setDayTime('evening');
        $evening->setEndTime(strftime("%X",mktime(23,59,59)));

        $manager->persist($evening);

        $night = new TimeClick();
        $night->setTime(strftime("%X",mktime(12,0,0)));
        $night->setClicks(0);
        $night->setDayTime('night');
        $night->setEndTime(strftime("%X",mktime(17,59,59)));

        $manager->persist($night);

        $manager->flush();
    }
}
