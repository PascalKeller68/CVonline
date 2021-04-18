<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $projectName;

    /**
     * @ORM\Column(type="text")
     */
    private $projectDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $projectLink;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $projectLanguages = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="relationProjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relationUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->projectDescription;
    }

    public function setProjectDescription(string $projectDescription): self
    {
        $this->projectDescription = $projectDescription;

        return $this;
    }

    public function getProjectLink(): ?string
    {
        return $this->projectLink;
    }

    public function setProjectLink(?string $projectLink): self
    {
        $this->projectLink = $projectLink;

        return $this;
    }

    public function getProjectLanguages(): ?array
    {
        return $this->projectLanguages;
    }

    public function setProjectLanguages(?array $projectLanguages): self
    {
        $this->projectLanguages = $projectLanguages;

        return $this;
    }

    public function getRelationUser(): ?User
    {
        return $this->relationUser;
    }

    public function setRelationUser(?User $relationUser): self
    {
        $this->relationUser = $relationUser;

        return $this;
    }
}
