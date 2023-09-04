<?php

namespace App\Entity;

use App\Repository\VocabularyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VocabularyRepository::class)]
class Vocabulary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vocabularies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Unit $Unit = null;

    #[ORM\Column(length: 255)]
    private ?string $nativePhrase = null;

    #[ORM\Column(length: 255)]
    private ?string $foreignPhrase = null;

    # at the beginning, the vocabulary isn't tested yet
    private ?bool $testedAndCorrect = false;

    # for later use on statistic info
    private ?int $testCounter = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?Unit
    {
        return $this->Unit;
    }

    public function setUnit(?Unit $Unit): static
    {
        $this->Unit = $Unit;

        return $this;
    }

    public function getNativePhrase(): ?string
    {
        return $this->nativePhrase;
    }

    public function setNativePhrase(string $nativePhrase): static
    {
        $this->nativePhrase = $nativePhrase;

        return $this;
    }

    public function getForeignPhrase(): ?string
    {
        return $this->foreignPhrase;
    }

    public function setForeignPhrase(string $foreignPhrase): static
    {
        $this->foreignPhrase = $foreignPhrase;

        return $this;
    }

    public function isTestedAndCorrect(): ?bool
    {
        return $this->testedAndCorrect;
    }

    public function setIsTestedAndCorrect(?bool $testedAndCorrect): static
    {
        $this->testedAndCorrect = $testedAndCorrect;

        return $this;
    }

    public function getTestCounter(): ?int
    {
        return $this->testCounter;
    }

    public function increaseTestCounter(): static
    {
        $this->testCounter++;

        return $this;
    }
}
