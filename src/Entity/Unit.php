<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    #[ORM\ManyToOne(inversedBy: 'nativeUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $nativeLanguage = null;

    #[ORM\ManyToOne(inversedBy: 'foreignUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $foreignLanguage = null;

    #[ORM\OneToMany(mappedBy: 'Unit', targetEntity: Vocabulary::class, orphanRemoval: true)]
    private Collection $vocabularies;

    public function __construct()
    {
        $this->vocabularies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getNativeLanguage(): ?Language
    {
        return $this->nativeLanguage;
    }

    public function setNativeLanguage(?Language $nativeLanguage): static
    {
        $this->nativeLanguage = $nativeLanguage;

        return $this;
    }

    public function getForeignLanguage(): ?Language
    {
        return $this->foreignLanguage;
    }

    public function setForeignLanguage(?Language $foreignLanguage): static
    {
        $this->foreignLanguage = $foreignLanguage;

        return $this;
    }

    /**
     * @return Collection<int, Vocabulary>
     */
    public function getVocabularies(): Collection
    {
        return $this->vocabularies;
    }

    public function addVocabulary(Vocabulary $vocabulary): static
    {
        if (!$this->vocabularies->contains($vocabulary)) {
            $this->vocabularies->add($vocabulary);
            $vocabulary->setUnit($this);
        }

        return $this;
    }

    public function removeVocabulary(Vocabulary $vocabulary): static
    {
        if ($this->vocabularies->removeElement($vocabulary)) {
            // set the owning side to null (unless already changed)
            if ($vocabulary->getUnit() === $this) {
                $vocabulary->setUnit(null);
            }
        }

        return $this;
    }
}
