<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\ProjectLanguages;
use App\Form\FormProjectType;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Empty_;
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

        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();

        $projectLanguages = $this->getDoctrine()
            ->getRepository(ProjectLanguages::class)
            ->findAll();

        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'projects' => $projects,
            'projectLanguages' => $projectLanguages
        ]);
    }



    #[Route('/createProject', name: 'create_project')]
    #[Route('/project/{id}/edit', name: 'edit_project')]
    public function formProject(Project $project = null, Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder): Response
    {
        if (!$project) {
            $project = new Project();
        }


        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        $formProject = $this->createForm(FormProjectType::class, $project);
        $formProject->handleRequest($request);

        if ($formProject->isSubmitted() && $formProject->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $user->addRelationProject($project);
            $manager->persist($project);
            $manager->persist($user);
            $manager->flush();

            if (!empty($projectLanguage)) {
                $projectLanguage = new ProjectLanguages();
                $projectLanguage->setRelationLanguage($project);
                $project->addProjectLanguage($projectLanguage);
                $manager->persist($projectLanguage);
                $manager->persist($project);
                $manager->flush();
            }
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/createProject.html.twig', [
            'controller_name' => 'DashboardController',
            'formProject' => $formProject->createView()
        ]);
    }
}
