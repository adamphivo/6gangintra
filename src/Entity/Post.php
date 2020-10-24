<?php

namespace App\Entity;

use App\Repository\PostRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $codeContent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textContent;

    /**
    * @ORM\Column(type="datetime")
    */
    private $dateAdded;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    // public function __construct()
    // {
    //     $this->dateAdded = new \DateTimeImmutable();
    // }

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

    public function getCodeContent(): ?string
    {
        return $this->codeContent;
    }

    public function setCodeContent(?string $codeContent): self
    {
        $this->codeContent = $codeContent;

        return $this;
    }

    public function getTextContent(): ?string
    {
        return $this->textContent;
    }

    public function setTextContent(?string $textContent): self
    {
        $this->textContent = $textContent;

        return $this;
    }

    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    public function setDateAdded($date)
    {
        $this->dateAdded = $date;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
