<?php

namespace App\Controller;

use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response {
        // find all method
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/register', name: 'register_user')]
    public function register(): Response {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
