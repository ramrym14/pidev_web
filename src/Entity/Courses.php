<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CoursesRepository;

#[ORM\Entity(repositoryClass: CoursesRepository::class)]
class Courses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 500)]
    private ?string $name =  null;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\NotBlank(message: 'ajouter description')]
    private ?string $description =  null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'choisir a difficulter')]
    #[Assert\Choice(choices: ['EASY', 'MEDIUM', 'HARD'], message: 'Choose a valid difficulty')]
    private ?string $difficulty = null;

    #[Assert\NotBlank(message: 'choisir a quel matiere')]
    #[ORM\ManyToOne(targetEntity: Subjects::class, inversedBy: 'courses')]
   #[ORM\JoinColumn(name: 'id_subject', referencedColumnName: 'id', nullable: true)]
   private ?Subjects $subject;



    public function getTests(): Collection
    {
        return $this->tests;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getSubject(): ?Subjects
    {
        return $this->subject;
    }

    public function setSubject(?Subjects $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function setTests(?Tests $tests): self
    {
        $this->tests = $tests;

        return $this;
    }
}
