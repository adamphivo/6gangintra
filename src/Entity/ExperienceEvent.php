<?php

namespace App\Entity;

use App\Repository\ExperienceEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceEventRepository::class)
 */
class ExperienceEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $experienceShift;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="experienceEvents")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="experienceEvents")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventType;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $madeAt;

    public function __construct()
    {
        $this->madeAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExperienceShift(): ?int
    {
        return $this->experienceShift;
    }

    public function setExperienceShift(int $experienceShift): self
    {
        $this->experienceShift = $experienceShift;

        return $this;
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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getMadeAt(): ?\DateTimeImmutable
    {
        return $this->madeAt;
    }

    public function setMadeAt(\DateTimeImmutable $madeAt): self
    {
        $this->madeAt = $madeAt;

        return $this;
    }
}
