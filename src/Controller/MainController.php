<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FormRegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('main/accueil.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/createAccount', name: 'create_account')]
    public function createAccount(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $formRegistration = $this->createForm(FormRegistrationType::class, $user);
        $formRegistration->handleRequest($request);

        $user->setRoles(["ROLE_USER"]);

        if ($formRegistration->isSubmitted() && $formRegistration->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('main/createAccount.html.twig', [
            'controller_name' => 'MainController',
            'form' => $formRegistration->createView()
        ]);
    }
}
