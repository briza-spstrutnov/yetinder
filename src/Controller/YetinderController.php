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

    #[Route('/yetinder/upvote', name: 'upvote')]
    public function upvote(Request $request, YetiRepository $yetiRepository, TimeClickRepository $timeClickRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $this->addTimeClicks($timeClickRepository);

        $rating = $yeti->getRating();
        $rating++;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }

    #[Route('/yetinder/downvote', name: 'downvote')]
    public function downvote(Request $request, YetiRepository $yetiRepository, TimeClickRepository $timeClickRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $this->addTimeClicks($timeClickRepository);

        $rating = $yeti->getRating();
        $rating--;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }

    public function addTimeClicks(TimeClickRepository $timeClickRepository){
//        date_default_timezone_set('Europe/Prague');
//        $time = $timeClickRepository->findAll();
//        $startTimeString = array();
//        $endTimeString = array();
//        foreach ($time as $t) {
//            $startTimeString[] = $t->getTime();
//            $endTimeString[] = $t->getEndTime();
//        }
//
//        $startTime = array();
//        foreach ($startTimeString as $time) {
//            $startTime[] = strtotime($time);
//        }
//
//        $endTime = array();
//        foreach ($endTimeString as $time) {
//            $endTime[] = strtotime($time);
//        }
//
//        $now = time();
//        $dayTime = array();
//        foreach (array_combine($startTime, $endTime) as $start => $end) {
//            if ($now >= $start && $now <= $end) {
//                $dayTime[] = $start;
//                $dayTime[] = $end;
//            }
//        }
//
//        $startDayTime = date('H:i:s', $dayTime[0]);
//        $clickTime = $timeClickRepository->findOneBy(['time' => $startDayTime]);
//        $clicks = $clickTime->getClicks();
//        $clicks++;
//        $clickTime->setClicks($clicks);
    }
}
