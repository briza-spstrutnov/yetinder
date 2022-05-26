<?php
namespace App\Controller;

use App\Form\RegisterFormType;
use App\Entity\Yeti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class YetiController extends AbstractController {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/yeti/register', name: 'yeti_new')]
    public function register(Request $request): Response {
        $yeti = new Yeti();
        $form = $this->createForm(RegisterFormType::class, $yeti);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newYeti = $form->getData();
            $newYeti->setRating(100);
            $this->em->persist($newYeti);
            $this->em->flush();
            return $this->redirectToRoute('best');
        }

        return $this->render('yeti/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
