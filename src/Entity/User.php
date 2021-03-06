<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields = {"email"},
 *  message = "Email already in use."
 * )
 * @UniqueEntity(
 *  fields = {"userName"},
 * message = "Username already in use."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="6", minMessage="Password must be at leat 6 characters long")
     */
    private $password;

    // Un champ de l'entite mais pas de la DB
    /**
     * @Assert\EqualTo(propertyPath="password", message="Password and confirmed password are different")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portraitUrl;

    /**
     * @ORM\Column(type="integer")
     */
    private $experience;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $subscribedAt;

    /**
     * @ORM\OneToMany(targetEntity=ExperienceEvent::class, mappedBy="user", orphanRemoval=true)
     */
    private $experienceEvents;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->subscribedAt = new \DateTimeImmutable();
        $this->experience = 0;
        $this->experienceEvents = new ArrayCollection();
    }

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
        return (string) $this->userName;
    }

    public function setUserName($string): self
    {
        $this->userName = $string;
        return $this;
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

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function getPortraitUrl(): ?string
    {
        return $this->portraitUrl;
    }

    public function setPortraitUrl(string $portraitUrl): self
    {
        $this->portraitUrl = $portraitUrl;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getSubscribedAt(): ?\DateTimeImmutable
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(\DateTimeImmutable $subscribedAt): self
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    /**
     * @return Collection|ExperienceEvent[]
     */
    public function getExperienceEvents(): Collection
    {
        return $this->experienceEvents;
    }

    public function addExperienceEvent(ExperienceEvent $experienceEvent): self
    {
        if (!$this->experienceEvents->contains($experienceEvent)) {
            $this->experienceEvents[] = $experienceEvent;
            $experienceEvent->setUser($this);
        }

        return $this;
    }

    public function removeExperienceEvent(ExperienceEvent $experienceEvent): self
    {
        if ($this->experienceEvents->removeElement($experienceEvent)) {
            // set the owning side to null (unless already changed)
            if ($experienceEvent->getUser() === $this) {
                $experienceEvent->setUser(null);
            }
        }

        return $this;
    }
}
