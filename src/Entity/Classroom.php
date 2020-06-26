<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"classroom:read"}},
 * )
 */
class Classroom
{
    const LEVELS = ['CP', 'CE1', 'CE2', 'CM1', 'CM2'];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"classroom:read", "user:read", "child:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classroom:read", "user:read", "child:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Child::class, mappedBy="classroom")
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="classroom")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="classroom")
     */
    private $annonces;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->annonces = new ArrayCollection();
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

    /**
     * @return Collection|Child[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Child $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setClassroom($this);
        }

        return $this;
    }

    public function removeStudent(Child $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getClassroom() === $this) {
                $student->setClassroom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClassroom($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClassroom() === $this) {
                $user->setClassroom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setClassroom($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getClassroom() === $this) {
                $annonce->setClassroom(null);
            }
        }

        return $this;
    }
}
