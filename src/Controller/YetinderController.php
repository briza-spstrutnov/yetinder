<?php

namespace App\Controller;

use App\Repository\TimeClickRepository;
use App\Repository\UserRepository;
use App\Repository\YetiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Yeti;

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
    public function yetinder(YetiRepository $yetiRepository, UserRepository $userRepository, UserInterface $user): Response {
//        $yetiDb = $yetiRepository->findAll();
        $yetiDb = $yetiRepository->createQueryBuilder('SELECT * FROM yeti');
//        $yeti = [rand(1, count($yetiDb))];
        dd($yetiDb);

        $securityContext = $this->container->get('security.authorization_checker');

        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        $userId = $user->getId();

        $userDb = $userRepository->find($userId);

//        $yeti = $yetiRepository->find($yeti[0]);

        return $this->render('yetinder/yetinder.html.twig', [
            'yeti' => $yetiDb
        ]);
    }

    #[Route('/yetinder/upvote', name: 'upvote')]
    public function upvote(Request $request, YetiRepository $yetiRepository, UserRepository $userRepository, TimeClickRepository $timeClickRepository, UserInterface $user): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $userId = $user->getId();

//        $userDb = $userRepository->find($userId);
//        $userDb->addLiked($yeti);

        $this->addTimeClicks($timeClickRepository);

        $rating = $yeti->getRating();
        $rating++;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }

    #[Route('/yetinder/downvote', name: 'downvote')]
    public function downvote(Request $request, YetiRepository $yetiRepository, UserRepository $userRepository, TimeClickRepository $timeClickRepository, UserInterface $user): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $userId = $user->getId();

//        $userDb = $userRepository->find($userId);
//        $userDb->addLiked($yeti);

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
