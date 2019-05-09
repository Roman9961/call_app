<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientMsisdnRepository")
 */
class ClientMsisdn
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
    private $msisdn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clientMsisdns")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="ClientMsisdn", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $parent;

    /**
     * @var User[]
     *
     * @ORM\OneToMany(targetEntity="ClientMsisdn", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMsisdn(): ?string
    {
        return $this->msisdn;
    }

    public function setMsisdn(string $msisdn): self
    {
        $this->msisdn = $msisdn;

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
     * @return ClientMsisdn
     */
    public function getParent(): ClientMsisdn
    {
        return $this->parent;
    }

    /**
     * @param ClientMsisdn $parent
     */
    public function setParent(ClientMsisdn $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return ClientMsisdn[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param ClientMsisdn[] $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

}
