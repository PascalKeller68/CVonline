<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use App\Form\ContactType;
use App\Entity\ProjectLanguages;
use Symfony\Component\Mime\Email;
use App\Form\FormRegistrationType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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

    #[Route('/cv', name: 'cv')]
    public function showCv(): Response
    {
        return $this->render('main/cv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('cvonlinepascalkeller@gmail.com')
                ->subject('Vous avez un mail de CVOnline')
                ->text(
                    'Expéditeur : ' . $contactFormData['email'] . \PHP_EOL .
                        $contactFormData['message'],
                    'text/plain'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('contact');
        }



        return $this->render('main/contact.html.twig', [
            'our_form' => $form->createView()
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


    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/project/view', name: 'view_project')]
    public function index(PaginatorInterface $paginator, ProjectRepository $repositoryProject, Request $request): Response
    {


        $projectLanguages = $this->getDoctrine()
            ->getRepository(ProjectLanguages::class)
            ->findAll();

        $queryBuilder = $repositoryProject->getQueryBuilderAllProject();
        $paginationProject = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('main/viewProject.html.twig', [
            'controller_name' => 'MainController',
            'projectLanguages' => $projectLanguages,
            'paginationProject' => $paginationProject
        ]);
    }

    #[Route('/project/{id}', name: 'show_project')]
    public function show($id)
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
        $projectLanguages = $this->getDoctrine()->getRepository(ProjectLanguages::class)->findBy(['relationLanguage' => $project]);

        return $this->render(
            'main/show.html.twig',
            [
                'project' => $project,
                'projectLanguages' => $projectLanguages,
            ]
        );
    }
}
