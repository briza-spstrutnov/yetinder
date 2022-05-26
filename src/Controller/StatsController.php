<?php

namespace App\Controller;

use App\Repository\YetiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController {
    #[Route('/stats', name: 'app_stats')]
    public function stats(YetiRepository $yetiRepository): Response {
        $allYeti = $yetiRepository->findAll();
        $femaleYeti = $yetiRepository->findBy(['gender' => 'Female']);
        $maleYeti = $yetiRepository->findBy(['gender' => 'Male']);

        $femalePercentage = count($femaleYeti) / count($allYeti) * 100;
        $malePercentage = count($maleYeti) / count($allYeti) * 100;
        dd(strftime("%X",mktime(6,0,0)));

        return $this->render('stats/stats.html.twig', [
            'allYeti' => count($allYeti),
            'allFemaleYeti' => count($femaleYeti),
            'allMaleYeti' => count($maleYeti),
            'femalePercentage' => $femalePercentage,
            'malePercentage' => $malePercentage,
        ]);
    }
}
