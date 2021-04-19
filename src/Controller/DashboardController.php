<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\ProjectLanguages;
use App\Form\FormProjectType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/createProject', name: 'create_project')]
    public function createProject(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder): Response
    {

        $project = new Project();
        $projectLanguage = new ProjectLanguages();
        //intégration du formulaire language dans le nouveau projet avant la création du form    
        $project->getProjectLanguage()->add($projectLanguage);

        $formProject = $this->createForm(FormProjectType::class, $project);
        $formProject->handleRequest($request);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        if ($formProject->isSubmitted() && $formProject->isValid()) {
            $manager = $this->getDoctrine()->getManager();


            $user->addRelationProject($project);


            $manager->persist($project);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('dashboard');
        }


        return $this->render('dashboard/createProject.html.twig', [
            'controller_name' => 'DashboardController',
            'formProject' => $formProject->createView()
        ]);
    }
}
