<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectLanguagesRepository;

/**
 * @ORM\Entity(repositoryClass=ProjectLanguagesRepository::class)
 */
class ProjectLanguages
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
    private $languageName;

    /**
     * @ORM\Column(type="integer")
     */
    private $languageUse;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectLanguages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $relationLanguage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguageName(): ?string
    {
        return $this->languageName;
    }

    public function setLanguageName(string $languageName): self
    {
        $this->languageName = $languageName;

        return $this;
    }

    public function getLanguageUse(): ?int
    {
        return $this->languageUse;
    }

    public function setLanguageUse(int $languageUse): self
    {
        $this->languageUse = $languageUse;

        return $this;
    }

    public function getRelationLanguage(): ?Project
    {
        return $this->relationLanguage;
    }

    public function setRelationLanguage(?Project $relationLanguage): self
    {
        $this->relationLanguage = $relationLanguage;

        return $this;
    }
}
