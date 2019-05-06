<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallingTimeRepository")
 */
class CallingTime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $callingDay;

    /**
     * @ORM\Column(type="time")
     */
    private $startCallingTime;

    /**
     * @ORM\Column(type="time")
     */
    private $endCallingTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCallingDay(): ?int
    {
        return $this->callingDay;
    }

    public function setCallingDay(int $callingDay): self
    {
        $this->callingDay = $callingDay;

        return $this;
    }

    public function getStartCallingTime(): ?\DateTimeInterface
    {
        return $this->startCallingTime;
    }

    public function setStartCallingTime(\DateTimeInterface $startCallingTime): self
    {
        $this->startCallingTime = $startCallingTime;

        return $this;
    }

    public function getEndCallingTime(): ?\DateTimeInterface
    {
        return $this->endCallingTime;
    }

    public function setEndCallingTime(\DateTimeInterface $endCallingTime): self
    {
        $this->endCallingTime = $endCallingTime;

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
