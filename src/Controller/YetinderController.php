<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TimeClickRepository;
use App\Repository\UserRepository;
use App\Repository\YetiRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Yeti;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class YetinderController extends AbstractController {
    private $em;
    private $requestStack;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'best')]
    public function index(YetiRepository $yetiRepository): Response {
        $yetiDb = $yetiRepository->getTopTen();

        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
            'yeti' => $yetiDb,
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(): Response {
        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata('App\Entity\Yeti', 'yeti');

        $query = $this->em->createNativeQuery('SELECT * FROM yeti WHERE RAND()<(SELECT ((1/COUNT(*))*10) FROM yeti) ORDER BY RAND() LIMIT 1', $rsm);
        $yeti = $query->getResult();

        return $this->render('yetinder/yetinder.html.twig', [
            'yeti' => $yeti[0]
        ]);
    }

    #[Route('/yetinder/vote/{number}', name: 'vote')]
    public function vote(Request $request, YetiRepository $yetiRepository, TimeClickRepository $timeClickRepository, int $number): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $rating = $yeti->getRating();
        $rating += $number;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }
}
