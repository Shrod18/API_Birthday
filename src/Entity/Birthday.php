<?php

namespace App\Entity;

use App\Repository\BirthdayRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass=BirthdayRepository::class)
 * @JMS\ExclusionPolicy("ALL")
 */
class Birthday
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups({"birthday_read"})
     * @JMS\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Groups({"birthday_read", "birthday_write"})
     * @JMS\Expose
     */
    private $title;

    /**
     * @ORM\Column(type="date_immutable")
     * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
     * @JMS\Groups({"birthday_read", "birthday_write"})
     * @JMS\Expose
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="birthdays")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Groups({"birthday_read", "birthday_write"})
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     */
    private $user;

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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

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

}
