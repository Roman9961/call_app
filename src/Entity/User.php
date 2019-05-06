<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CallingTask", mappedBy="user")
     */
    private $callingTasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CallingList", mappedBy="user")
     */
    private $callingLists;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $accountCode;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $parent;

    /**
     * @var User[]
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Files",cascade={"persist"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * @var bool|string
     */
    private $plainPassword;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function __construct()
    {
        $this->callingTasks = new ArrayCollection();
        $this->callingLists = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = json_decode($this->roles, true)??[];

        if (empty($roles)){
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
       return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|CallingTask[]
     */
    public function getCallingTasks(): Collection
    {
        return $this->callingTasks;
    }

    public function addCallingTask(CallingTask $callingTask): self
    {
        if (!$this->callingTasks->contains($callingTask)) {
            $this->callingTasks[] = $callingTask;
            $callingTask->setUser($this);
        }

        return $this;
    }

    public function removeCallingTask(CallingTask $callingTask): self
    {
        if ($this->callingTasks->contains($callingTask)) {
            $this->callingTasks->removeElement($callingTask);
            // set the owning side to null (unless already changed)
            if ($callingTask->getUser() === $this) {
                $callingTask->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CallingList[]
     */
    public function getCallingLists(): Collection
    {
        return $this->callingLists;
    }

    public function addCallingList(CallingList $callingList): self
    {
        if (!$this->callingLists->contains($callingList)) {
            $this->callingLists[] = $callingList;
            $callingList->setUser($this);
        }

        return $this;
    }

    public function removeCallingList(CallingList $callingList): self
    {
        if ($this->callingLists->contains($callingList)) {
            $this->callingLists->removeElement($callingList);
            // set the owning side to null (unless already changed)
            if ($callingList->getUser() === $this) {
                $callingList->setUser(null);
            }
        }

        return $this;
    }

    public function setRoles($roles): self
    {
        $this->roles = json_encode($roles);

        return $this;
    }

    /**
     * @return User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param User $parent
     * @return User
     */
    public function setParent($parent)
    {

        $this->parent = $parent;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentId()
    {
        return $this->parent ? $this->parent->getId() : null;
    }

    /**
     * @return User[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param User[] $children
     * @return User
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountCode()
    {
        return $this->accountCode??$this->id;
    }

    public function setAccountCode($accountCode)
    {
        return $this->accountCode = $accountCode;
    }

    public function generateAccountCode()
    {
        if (!$this->id) {
            throw new \LogicException('First you need flush user!');
        }

        if(in_array('ROLE_SUPERVISOR', $this->getRoles())){
            $this->accountCode = $this->id;
        }else{
            if($this->parent && in_array('ROLE_SUPERVISOR', $this->parent->getRoles())) {
                    $this->accountCode = $this->parent->getId();
            }elseif(!$this->parent){
                    $this->accountCode = $this->id;
            }
        }
    }

    public function setPlainPassword()
    {
        $this->plainPassword = substr(md5(openssl_random_pseudo_bytes(12)),0, 12);
    }

    /**
     * @return bool|string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function getAllChildrens(){
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
