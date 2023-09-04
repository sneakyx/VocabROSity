<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $identifier = null;

    #[ORM\OneToMany(mappedBy: 'nativeLanguage', targetEntity: Unit::class)]
    private Collection $nativeUnits;

    #[ORM\OneToMany(mappedBy: 'foreignLanguage', targetEntity: Unit::class)]
    private Collection $foreignUnits;


    public function __construct(string $identifier = null)
    {
        $this->nativeUnits = new ArrayCollection();
        $this->foreignUnits = new ArrayCollection();
        $this->identifier = $identifier;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getNativeUnits(): Collection
    {
        return $this->nativeUnits;
    }

    public function addNativeUnit(Unit $nativeUnit): static
    {
        if (!$this->nativeUnits->contains($nativeUnit)) {
            $this->nativeUnits->add($nativeUnit);
            $nativeUnit->setNativeLanguage($this);
        }

        return $this;
    }

    public function removeNativeUnit(Unit $nativeUnit): static
    {
        if ($this->nativeUnits->removeElement($nativeUnit)) {
            // set the owning side to null (unless already changed)
            if ($nativeUnit->getNativeLanguage() === $this) {
                $nativeUnit->setNativeLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getForeignUnits(): Collection
    {
        return $this->foreignUnits;
    }

    public function addForeignUnit(Unit $foreignUnit): static
    {
        if (!$this->foreignUnits->contains($foreignUnit)) {
            $this->foreignUnits->add($foreignUnit);
            $foreignUnit->setForeignLanguage($this);
        }

        return $this;
    }

    public function removeForeignUnit(Unit $foreignUnit): static
    {
        if ($this->foreignUnits->removeElement($foreignUnit)) {
            // set the owning side to null (unless already changed)
            if ($foreignUnit->getForeignLanguage() === $this) {
                $foreignUnit->setForeignLanguage(null);
            }
        }

        return $this;
    }
}
