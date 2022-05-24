<?php

namespace App\Controller;

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
    public function index(): Response {


        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(): Response {

    }
}
