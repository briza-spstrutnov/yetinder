<?php

namespace App\Controller;

use App\Repository\YetiRepository;
use App\Repository\TimeClickRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

class StatsController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

//    #[Route('/stats', name: 'app_stats')]
//    public function stats(YetiRepository $yetiRepository, TimeClickRepository $timeClickRepository): Response {
//        $allYeti = $yetiRepository->findAll();
//        $femaleYeti = $yetiRepository->findBy(['gender' => 'Female']);
//        $maleYeti = $yetiRepository->findBy(['gender' => 'Male']);
//
//        $femalePercentage = round(count($femaleYeti) / count($allYeti) * 100, 2);
//        $malePercentage = round(count($maleYeti) / count($allYeti) * 100, 2);
//
//        // Time stats
//        $morning = $timeClickRepository->findBy(['dayTime' => 'morning']);
//        $morningClicks = null;
//        foreach ($morning as $mClicks) {
//            $morningClicks = $mClicks->getClicks();
//        }
//
//        $afternoon = $timeClickRepository->findBy(['dayTime' => 'afternoon']);
//        $afternoonClicks = null;
//        foreach ($afternoon as $aClicks) {
//            $afternoonClicks = $aClicks->getClicks();
//        }
//
//
//        $evening = $timeClickRepository->findBy(['dayTime' => 'evening']);
//        $eveningClicks = null;
//        foreach ($evening as $eClicks) {
//            $eveningClicks = $eClicks->getClicks();
//        }
//
//        $night = $timeClickRepository->findBy(['dayTime' => 'night']);
//        $nightClicks = null;
//        foreach($night as $nClicks){
//            $nightClicks = $nClicks->getClicks();
//        }
//
//        $allClicks = $nightClicks + $afternoonClicks + $eveningClicks + $morningClicks;
//
//        if($allClicks != 0){
//            $morningPercentage = round($morningClicks / $allClicks * 100, 2);
//            $afternoonPercentage = round($afternoonClicks / $allClicks * 100, 2);
//            $eveningPercentage = round($eveningClicks / $allClicks * 100, 2);
//            $nightPercentage = round($nightClicks / $allClicks * 100, 2);
//        }else{
//            $morningPercentage = 0;
//            $afternoonPercentage = 0;
//            $eveningPercentage = 0;
//            $nightPercentage = 0;
//        }
//
//        return $this->render('stats/stats.html.twig', [
//            'allYeti' => count($allYeti),
//            'allFemaleYeti' => count($femaleYeti),
//            'allMaleYeti' => count($maleYeti),
//            'femalePercentage' => $femalePercentage,
//            'malePercentage' => $malePercentage,
//            'morning' => $morningClicks,
//            'afternoon' => $afternoonClicks,
//            'evening' => $eveningClicks,
//            'night' => $nightClicks,
//            'all' => $allClicks,
//            'morningPercentage' => $morningPercentage,
//            'afternoonPercentage' => $afternoonPercentage,
//            'eveningPercentage' => $eveningPercentage,
//            'nightPercentage' => $nightPercentage,
//        ]);
//    }
    #[Route('/stats', name: 'app_stats')]
    public function stats(YetiRepository $yetiRepository): Response{
        // SELECT COUNT(*), gender FROM yeti GROUP BY gender
        $qb = $yetiRepository->createQueryBuilder('yeti');

        $qb
            ->select('count(yeti)')
            ->groupBy('yeti.gender');

        $femaleCount = $qb->getQuery()->getResult()[0];
        $maleCount = $qb->getQuery()->getResult()[1];
        $all = $femaleCount[1] + $maleCount[1];

        $femalePercentage = ($femaleCount[1] / $all) * 100;
        $malePercentage = ($maleCount[1] / $all) * 100;

        return $this->render('stats/stats.html.twig', [
            'allYeti' => $all,
            'allFemaleYeti' => $femaleCount[1],
            'allMaleYeti' => $maleCount[1],
            'femalePercentage' => round($femalePercentage, 2),
            'malePercentage' => round($malePercentage, 2),
        ]);
    }
}
