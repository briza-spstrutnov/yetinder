<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\YetiRepository;
use App\Entity\User;
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

        return $this->render('yetinder/best.html.twig', [
            'controller_name' => 'YetinderController',
            'yeti' => $yeti,
        ]);
    }

    #[Route('/yetinder', name: 'yetinder')]
    public function yetinder(YetiRepository $yetiRepository, UserRepository $userRepository): Response {
        /* TODO:
            1. Načíst celou db
            2. Zkontrolovat podle id, na které už uživatel reagoval
            3. Smazat ty, na které už uživatel reagoval
            4. Udělat random z upraveného arraye
            5. Vypsat na stránku
        */


        $yetiDb = $yetiRepository->findAll();

        $yeti = $yetiDb[rand(0, count($yetiDb) - 1)];

        $session = $this->requestStack->getSession();
        $user = $session->get('user');
        $users = $userRepository->findAll();

        // redirect pokud uživatel není přihlášený
        if(!$user){
            return $this->redirectToRoute('user_login');
        }

        $userId = null;
        foreach($user as $credential){
            $userId = $credential->getId();
        }

        $userDb = $userRepository->find($userId);
        $likedId = $userDb->getLiked()->getValues();

        if(count($likedId) != count($yetiDb)){
            foreach($likedId as $liked){
                if($liked->getId() == $yeti->getId()){
                    return $this->redirectToRoute('yetinder');
                }
            }
        }

        return $this->render('yetinder/yetinder.html.twig', [
            'yeti' => $yeti
        ]);
    }

    #[Route('/yetinder/upvote', name: 'upvote')]
    public function upvote(Request $request, YetiRepository $yetiRepository, UserRepository $userRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $session = $this->requestStack->getSession();
        $user = $session->get('user');

        $userId = null;
        foreach($user as $credential){
            $userId = $credential->getId();
        }

        $userDb = $userRepository->find($userId);
        $userDb->addLiked($yeti);

        $rating = $yeti->getRating();
        $rating++;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }

    #[Route('/yetinder/downvote', name: 'downvote')]
    public function downvote(Request $request, YetiRepository $yetiRepository, UserRepository $userRepository): Response {
        $id = $request->request->get('id');
        $yeti = $yetiRepository->find($id);

        $session = $this->requestStack->getSession();
        $user = $session->get('user');

        $userId = null;
        foreach($user as $credential){
            $userId = $credential->getId();
        }

        $userDb = $userRepository->find($userId);
        $userDb->addLiked($yeti);

        $rating = $yeti->getRating();
        $rating--;
        $yeti->setRating($rating);
        $this->em->persist($yeti);
        $this->em->flush();

        return $this->redirectToRoute('yetinder');
    }
}
