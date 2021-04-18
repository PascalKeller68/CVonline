<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $role = [];

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="relationUser", orphanRemoval=true)
     */
    private $relationProjects;

    public function __construct()
    {
        $this->relationProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getRelationProjects(): Collection
    {
        return $this->relationProjects;
    }

    public function addRelationProject(Project $relationProject): self
    {
        if (!$this->relationProjects->contains($relationProject)) {
            $this->relationProjects[] = $relationProject;
            $relationProject->setRelationUser($this);
        }

        return $this;
    }

    public function removeRelationProject(Project $relationProject): self
    {
        if ($this->relationProjects->removeElement($relationProject)) {
            // set the owning side to null (unless already changed)
            if ($relationProject->getRelationUser() === $this) {
                $relationProject->setRelationUser(null);
            }
        }

        return $this;
    }
}
