<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallingTaskRepository")
 */
class CallingTask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CallingList")
     * @ORM\JoinColumn(nullable=true)
     */
    private $callingList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="callingTasks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CallingTime")
     */
    private $callingTimes;

    public function __construct()
    {
        $this->callingTimes = new ArrayCollection();
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

    public function getCallingList(): ?CallingList
    {
        return $this->callingList;
    }

    public function setCallingList(?CallingList $callingList): self
    {
        $this->callingList = $callingList;

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

    /**
     * @return Collection|CallingTime[]
     */
    public function getCallingTimes(): Collection
    {
        return $this->callingTimes;
    }

    public function addCallingTime(CallingTime $callingTime): self
    {
        if (!$this->callingTimes->contains($callingTime)) {
            $this->callingTimes[] = $callingTime;
        }

        return $this;
    }

    public function removeCallingTime(CallingTime $callingTime): self
    {
        if ($this->callingTimes->contains($callingTime)) {
            $this->callingTimes->removeElement($callingTime);
        }

        return $this;
    }
}
