<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="relationProjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relationUser;



    /**
     * @ORM\OneToMany(targetEntity=ProjectLanguages::class, mappedBy="relationLanguage", orphanRemoval=true, cascade={"persist"})
     */
    protected $projectLanguages;

    public function __construct()
    {
        $this->projectLanguages = new ArrayCollection();
    }

    public function getProjectLanguage(): Collection
    {
        return $this->projectLanguages;
    }

    public function addProjectLanguage(ProjectLanguages $projectLanguage): self
    {
        //$this->tags->add($projectLanguage);
        if (!$this->projectLanguages->contains($projectLanguage)) {
            $this->projectLanguages[] = $projectLanguage;
            $projectLanguage->setRelationLanguage($this);
        }

        return $this;
    }

    public function removeProjectLanguage(ProjectLanguages $projectLanguage): self
    {
        if ($this->projectLanguage->removeElement($projectLanguage)) {
            // set the owning side to null (unless already changed)
            if ($projectLanguage->getRelationLanguage() === $this) {
                $projectLanguage->setRelationLanguage(null);
            }
        }

        return $this;
    }




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
