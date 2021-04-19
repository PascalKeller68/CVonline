<?php

namespace App\Entity;

use App\Repository\ProjectLanguagesRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
