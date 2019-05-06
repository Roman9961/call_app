<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallingListRepository")
 */
class CallingList
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
     * @ORM\ManyToMany(targetEntity="App\Entity\ClientMsisdn")
     */
    private $clientMsisdns;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="callingLists")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function __construct()
    {
        $this->clientMsisdns = new ArrayCollection();
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
     * @return Collection|ClientMsisdn[]
     */
    public function getClientMsisdns(): Collection
    {
        return $this->clientMsisdns;
    }

    public function addClientMsisdn(ClientMsisdn $clientMsisdn): self
    {
        if (!$this->clientMsisdns->contains($clientMsisdn)) {
            $this->clientMsisdns[] = $clientMsisdn;
        }

        return $this;
    }

    public function removeClientMsisdn(ClientMsisdn $clientMsisdn): self
    {
        if ($this->clientMsisdns->contains($clientMsisdn)) {
            $this->clientMsisdns->removeElement($clientMsisdn);
        }

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
