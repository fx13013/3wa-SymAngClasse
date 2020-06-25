<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChildRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChildRepository::class)
 * @ApiResource
 */
class Child
{
    const GENRES = ['Masculin', 'Féminin'];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=3, max=255, minMessage="Le prénom doit faire 3 caractères minimum", maxMessage="Le prénom doit faire 255 caractères maximum")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3, max=255, minMessage="Le prénom doit faire 3 caractères minimum", maxMessage="Le prénom doit faire 255 caractères maximum")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $securiteSociale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroCaf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assuranceScolaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreFreres;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreSoeurs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $professionMere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $professionPere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneDomicile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephonePere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneMere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomMedecinTraitant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneMedecin;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     */
    private $classroom;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="student", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSecuriteSociale(): ?string
    {
        return $this->securiteSociale;
    }

    public function setSecuriteSociale(?string $securiteSociale): self
    {
        $this->securiteSociale = $securiteSociale;

        return $this;
    }

    public function getNumeroCaf(): ?string
    {
        return $this->numeroCaf;
    }

    public function setNumeroCaf(?string $numeroCaf): self
    {
        $this->numeroCaf = $numeroCaf;

        return $this;
    }

    public function getAssuranceScolaire(): ?string
    {
        return $this->assuranceScolaire;
    }

    public function setAssuranceScolaire(?string $assuranceScolaire): self
    {
        $this->assuranceScolaire = $assuranceScolaire;

        return $this;
    }

    public function getNombreFreres(): ?int
    {
        return $this->nombreFreres;
    }

    public function setNombreFreres(?int $nombreFreres): self
    {
        $this->nombreFreres = $nombreFreres;

        return $this;
    }

    public function getNombreSoeurs(): ?int
    {
        return $this->nombreSoeurs;
    }

    public function setNombreSoeurs(?int $nombreSoeurs): self
    {
        $this->nombreSoeurs = $nombreSoeurs;

        return $this;
    }

    public function getProfessionMere(): ?string
    {
        return $this->professionMere;
    }

    public function setProfessionMere(?string $professionMere): self
    {
        $this->professionMere = $professionMere;

        return $this;
    }

    public function getProfessionPere(): ?string
    {
        return $this->professionPere;
    }

    public function setProfessionPere(?string $professionPere): self
    {
        $this->professionPere = $professionPere;

        return $this;
    }

    public function getTelephoneDomicile(): ?string
    {
        return $this->telephoneDomicile;
    }

    public function setTelephoneDomicile(?string $telephoneDomicile): self
    {
        $this->telephoneDomicile = $telephoneDomicile;

        return $this;
    }

    public function getTelephonePere(): ?string
    {
        return $this->telephonePere;
    }

    public function setTelephonePere(?string $telephonePere): self
    {
        $this->telephonePere = $telephonePere;

        return $this;
    }

    public function getTelephoneMere(): ?string
    {
        return $this->telephoneMere;
    }

    public function setTelephoneMere(?string $telephoneMere): self
    {
        $this->telephoneMere = $telephoneMere;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    public function getNomMedecinTraitant(): ?string
    {
        return $this->nomMedecinTraitant;
    }

    public function setNomMedecinTraitant(?string $nomMedecinTraitant): self
    {
        $this->nomMedecinTraitant = $nomMedecinTraitant;

        return $this;
    }

    public function getTelephoneMedecin(): ?string
    {
        return $this->telephoneMedecin;
    }

    public function setTelephoneMedecin(?string $telephoneMedecin): self
    {
        $this->telephoneMedecin = $telephoneMedecin;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newStudent = null === $user ? null : $this;
        if ($user->getStudent() !== $newStudent) {
            $user->setStudent($newStudent);
        }

        return $this;
    }
}
