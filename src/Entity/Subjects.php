<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\SubjectsRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubjectsRepository::class)]
/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectsRepository")
 * @ORM\Table(name="subjects")
 */
#[UniqueEntity(fields: ['name'], message: 'This name is already taken.')]
class Subjects
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups ("subject")]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;


    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Groups ("subject")]
   
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\NotBlank]
    #[Groups ("subject")]
    private ?string $description =  null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups ("subject")]
    #[Assert\NotBlank(message: 'Choisir a classe')]
    #[Assert\Choice(choices: ['A1', 'B3', 'B2', 'A2', 'A3', 'B1'], message: 'Choose a valid classe_esprit.')]
    private ?string $classes_esprit = null;

    #[ORM\OneToMany(targetEntity: Courses::class, mappedBy: "subjects")]
    private ?Collection $courses;


    
     /**
     *
     * @var int
     *@Groups({"groups", "Subjects"})
     */
    private $ide;



    public function __construct()
    {
        $this->courses = new ArrayCollection();
        // $this->questions = new ArrayCollection();
        // $this->tests = new ArrayCollection();
    }

    // public function getTests(): Collection
    // {
    //     return $this->tests;
    // }



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

    public function getClassesEsprit(): ?string
    {
        return $this->classes_esprit;
    }

    public function setClassesEsprit(string $classes_esprit): self
    {
        $this->classes_esprit = $classes_esprit;

        return $this;
    }

    public function getCourse(): ?Collection
    {
        return $this->courses;
    }

    public function setCourse(?Collection $courses): self
    {
        $this->courses = $courses;
        return $this;
    }

    // public function getQuestion(): ?Collection
    // {
    //     return $this->questions;
    // }

    // public function setQuestion(?Collection $questions): self
    // {
    //     $this->questions = $questions;
    //     return $this;
    // }

    public function addCourse(Courses $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setSubject($this);
        }

        return $this;
    }

    public function removeCourse(Courses $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getSubject() === $this) {
                $course->setSubject(null);
            }
        }

        return $this;
    }

    // public function addQuestion(Questions $question): self
    // {
    //     if (!$this->questions->contains($question)) {
    //         $this->questions->add($question);
    //         $question->setSubject($this);
    //     }

    //     return $this;
    // }

    // public function removeQuestion(Questions $question): self
    // {
    //     if ($this->questions->removeElement($question)) {
    //         // set the owning side to null (unless already changed)
    //         if ($question->getSubject() === $this) {
    //             $question->setSubject(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function addTest(Tests $test): self
    // {
    //     if (!$this->tests->contains($test)) {
    //         $this->tests->add($test);
    //         $test->setSubject($this);
    //     }

    //     return $this;
    // }

    // public function removeTest(Tests $test): self
    // {
    //     if ($this->tests->removeElement($test)) {
    //         // set the owning side to null (unless already changed)
    //         if ($test->getSubject() === $this) {
    //             $test->setSubject(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getCourses(): Collection
    {
        return $this->courses;
    }


    // public function getQuestions(): Collection
    // {
    //     return $this->questions;
    // }
}
