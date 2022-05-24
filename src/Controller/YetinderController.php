<?php

namespace App\Controller;

use App\Entity\Yeti;
use App\Repository\YetiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YetinderController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/', name: 'best')]
    public function index(YetiRepository $yetiRepository): Response {
        $yetiDb = $yetiRepository->findBy([], ['rating' => 'DESC']);
        $yeti = array();
//        dd($yeti[10]);

        for($x = 0; $x < 10; $x++){
            $yeti[] = $yetiDb[$x];
        }

        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
            'yeti' => $yeti,
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(): Response {

    }
}
