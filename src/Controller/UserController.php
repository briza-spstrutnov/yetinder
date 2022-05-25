<?php

namespace App\Controller;

use App\Form\UserLoginFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserRegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController extends AbstractController {
    private $em;
    private $requestStack;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    #[Route('/user/register', name: 'user_register')]
    public function register(Request $request): Response {
        $user = new User();
        $form = $this->createForm(UserRegisterFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            $factory = new PasswordHasherFactory([
                'common' => ['algorithm' => 'bcrypt'],
                'memory-hard' => ['algorithm' => 'sodium'],
            ]);

            $passwordHasher = $factory->getPasswordHasher('common');
            $plainTextPassword = $newUser->getPassword();
            $hashedPassword = $passwordHasher->hash($plainTextPassword);

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
        $form = $this->createForm(UserLoginFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInput = $form->getData();
            $userDb = $userRepository->findBy(['username' => $userInput->getUsername()]);

            $session = $this->requestStack->getSession();

            $factory = new PasswordHasherFactory([
                'common' => ['algorithm' => 'bcrypt'],
                'memory-hard' => ['algorithm' => 'sodium'],
            ]);

            $passwordHasher = $factory->getPasswordHasher('common');

            if (!$userDb) {
                return $this->redirectToRoute('user_login');
            }

            foreach ($userDb as $credential) {
                $password = $credential->getPassword();
                if (!$passwordHasher->verify($password, $userInput->getPassword())){
                    return $this->redirectToRoute('user_login');
                }
            }

            $session->set('user', $userDb);
            dd($session->get('user'));
            $session->set('isAuth', true);

            return $this->redirectToRoute('best');
        }

        return $this->render('user/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
