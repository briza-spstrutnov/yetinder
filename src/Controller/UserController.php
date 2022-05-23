<?php

namespace App\Controller;

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
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/register', name: 'app_user')]
    public function register(): Response {
        return $this->render('user/register.html.twig');
    }
}
