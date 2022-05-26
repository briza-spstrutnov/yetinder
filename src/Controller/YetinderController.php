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

class YetinderController extends AbstractController {
    private $em;
    private $requestStack;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'best')]
    public function index(YetiRepository $yetiRepository): Response {
        $yetiDb = $yetiRepository->findBy([], ['rating' => 'DESC'], 10);

        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
            'yeti' => $yetiDb,
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(YetiRepository $yetiRepository, UserRepository $userRepository, UserInterface $user): Response {
        $yetiDb = $yetiRepository->findAll();

        $session = $this->requestStack->getSession();

        $securityContext = $this->container->get('security.authorization_checker');

        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        $userId = $user->getId();

        $userDb = $userRepository->find($userId);
//        $liked = $userDb->getLiked()->getValues();
        $likedId = array();
//        foreach ($liked as $x) {
//            $likedId[] = $x->getId();
//        }

        $yetiId = array();
        foreach ($yetiDb as $y) {
            $yetiId[] = $y->getId();
        }

        foreach ($likedId as $l) {
            foreach (array_keys($yetiId, $l, true) as $key) {
                unset($yetiId[$key]);
            }
        }

        $yetiNoInteraction = array();
        foreach ($yetiId as $i) {
            $yetiNoInteraction[] = $i;
        }

        if (count($yetiNoInteraction) <= 0) {
            return $this->render('yetinder/yetinder.html.twig');
        }

        $yeti = $yetiNoInteraction[rand(0, count($yetiNoInteraction) - 1)];
        $yeti = $yetiRepository->find($yeti);

        return $this->render('yetinder/yetinder.html.twig', [
            'yeti' => $yeti
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
