<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"user:read"}},
 *  denormalizationContext={"groups"={"user:write"}}
 * )
 * @UniqueEntity("email", message="Cette addresse email existe déjà")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "child:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "child:read", "user:write"})
     * @Assert\NotBlank(message="L'adresse email est obligatoire")
     * @Assert\Email(message="L'adresse email doit avoir un format valide")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     * @Assert\Length(min=8, minMessage="Le mot de passe doit faire 8 caractères au minimum")
     * @Groups("user:write")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="La confirmation n'est pas identique au mot de passe")
     * @Groups("user:write")
     */
    private $confirmation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "child:read", "user:write"})
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3, max=255, minMessage="Le prénom doit faire 3 caractères minimum", maxMessage="Le prénom doit faire 255 caractères maximum")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "child:read", "user:write"})
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3, max=255, minMessage="Le prénom doit faire 3 caractères minimum", maxMessage="Le prénom doit faire 255 caractères maximum")
     */
    private $lastName;

    /**
     * @ORM\OneToOne(targetEntity=Child::class, inversedBy="user", cascade={"persist", "remove"})
     * @Groups("user:write")
     * @Assert\Valid()
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="users")
     * @Assert\Choice(choices=Classroom::LEVELS, message="La classe doit être CP, CE1, CE2, CM1, ou CM2")
     * @Groups({"user:read"})
     */
    private $classroom;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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

    public function getStudent(): ?Child
    {
        return $this->student;
    }

    public function setStudent(?Child $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get the value of confirmation
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set the value of confirmation
     *
     * @return  self
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }
}
