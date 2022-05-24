<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Form\RegisterFormType;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session;

class UserController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/user/index', name: 'app_index')]
    public function index(): Response {
        // find all method
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/register', name: 'user_register')]
    public function register(Request $request): Response {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();
            $passwordHasher = $factory->getPasswordHasher('common');
            $plainPassword = $newUser->getPassword();
            $hashedPassword = $passwordHasher->hash($plainPassword);
            $newUser->setPassword($hashedPassword);

            $this->em->persist($newUser);
            $this->em->flush();
            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/login', name: 'user_login')]
    public function login(Request $request, UserRepository $userRepository): Response {
        $user = new User();

        $form = $this->createForm(LoginFormType::class, $user);

        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userInput = $form->getData();
            $userInDb = $userRepository->findBy(['username' => $userInput->getUsername()]);

            $passwordHasher = $factory->getPasswordHasher('common');

            if (!$userInDb) {
                return $this->redirectToRoute('user_login');
            }

            foreach($userInDb as $credential){
                $password = $credential->getPassword();
                if(!$passwordHasher->verify($password, $userInput->getPassword())){
                    return $this->redirectToRoute('user_login');
                }
                dd($userInput->getPassword());
            }
        }

        return $this->render('user/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
