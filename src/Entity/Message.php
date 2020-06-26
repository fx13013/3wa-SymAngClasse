<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MessageRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"message:read"}},
 * )
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"message:read", "child:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"message:read", "child:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"message:read", "child:read"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date de création doit être renseignée")
     * @Groups({"message:read", "child:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(message="La date doit être au format YYYY-MM-DD")
     * @Groups({"message:read", "child:read"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Child::class, inversedBy="messages")
     * @Assert\NotBlank(message="L'auteur du message est obligatoire")
     * @Groups({"message:read"})
     */
    private $child;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getChild(): ?Child
    {
        return $this->child;
    }

    public function setChild(?Child $child): self
    {
        $this->child = $child;

        return $this;
    }
}
