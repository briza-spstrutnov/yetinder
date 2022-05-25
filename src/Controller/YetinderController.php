<?php

namespace App\Controller;

use App\Repository\YetiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class YetinderController extends AbstractController {
    private $em;
    private $requestStack;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'best')]
    public function index(YetiRepository $yetiRepository): Response {
        $yetiDb = $yetiRepository->findBy([], ['rating' => 'DESC']);
        $yeti = array();

        for ($x = 0; $x < 10; $x++) {
            $yeti[] = $yetiDb[$x];
        }

        $session = $this->requestStack->getSession();

        dd($session->get('user'));

        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
            'yeti' => $yeti,
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(YetiRepository $yetiRepository): Response {
        $yetiDb = $yetiRepository->findAll();

        $yeti = $yetiDb[rand(0, count($yetiDb) - 1)];

        return $this->render('yetinder/yetinder.html.twig', [
            'yeti' => $yeti
        ]);
    }

    #[Route('/yetinder/upvote', name: 'upvote')]
    public function upvote(Request $request, YetiRepository $yetiRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $rating = $yeti->getRating();
        $rating++;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }

    #[Route('/yetinder/downvote', name: 'downvote')]
    public function downvote(Request $request, YetiRepository $yetiRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $rating = $yeti->getRating();
        $rating--;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }
}
