<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use App\Form\FormProjectType;
use PhpParser\Node\Expr\Empty_;
use App\Entity\ProjectLanguages;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(PaginatorInterface $paginator, ProjectRepository $repositoryProject, Request $request): Response
    {
        $projectLanguages = $this->getDoctrine()
            ->getRepository(ProjectLanguages::class)
            ->findAll();

        $queryBuilder = $repositoryProject->getQueryBuilderAllProject();
        $paginationProject = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        //$paginationProject->Configurator('knp_paginator');

        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'projectLanguages' => $projectLanguages,
            'paginationProject' => $paginationProject
        ]);
    }

    #[Route('/dashboard/createProject', name: 'create_project')]
    public function formProject(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder): Response
    {

        $project = new Project();

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
            'formProject' => $formProject->createView(),
            'editMode' => false
        ]);
    }


    #[Route('/dashboard/edit/{id}', name: 'edit_project')]
    public function edit($id, Request $request, ManagerRegistry $entityManager): Response
    {
        if (null === $project = $entityManager->getRepository(Project::class)->find($id)) {
            throw $this->createNotFoundException('No project found for id ' . $id);
        }

        // $projectLanguages = $this->getDoctrine()->getRepository(ProjectLanguages::class)->findBy(['relationLanguage' => $project]);
        $originalLanguages = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($project->getProjectLanguage() as $projectLanguages) {
            $originalLanguages->add($projectLanguages);
        }

        $editForm = $this->createForm(FormProjectType::class, $project);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // remove the relationship between the projectLanguages and the project
            foreach ($originalLanguages as $projectLanguages) {
                if (false === $project->getProjectLanguage()->contains($projectLanguages)) {
                    $projectLanguages->setRelationLanguage(null);

                    $entityManager->persist($projectLanguages);
                }
            }

            $entityManager->persist($project);
            $entityManager->flush();

            // redirect back to some edit page
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/createProject.html.twig', [
            'controller_name' => 'DashboardController',
            'formProject' => $editForm->createView(),
            'editMode' => true
        ]);
    }

    #[Route('/dashboard/delete/{id}', name: 'delete_project')]
    public function deleteProject($id, Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);

        $projectlanguages = $this->getDoctrine()
            ->getRepository(ProjectLanguages::class)
            ->findBy(['relationLanguage' => $id]);

        $manager = $this->getDoctrine()->getManager();

        if (!empty($projectLanguage)) {

            foreach ($$projectlanguages as $projectLanguage) {

                $projectLanguage->setRelationLanguage(null);
                $project->removeProjectLanguage($projectLanguage);
                $manager->persist($projectLanguage);
                $manager->persist($project);
            }
        }

        $user->removeRelationProject($project);
        $manager->persist($project);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('dashboard');
    }
}
