<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/user/register', name: 'user_register')]
    public function register(Request $request): Response {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newUser = $form -> getData();

            $this->em->persist($newUser);
            $this->em->flush();

            return $this->redirectToRoute('best');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
