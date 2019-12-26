<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    /*
     * @var string|null
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     *
    private $username;*/

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", length=45, nullable=false)
     */
    private $roles = [];
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="TodoList", mappedBy="user")
     * @ORM\OrderBy({"duedate" = "DESC"})
     */
    private $lists;

    public function __construct()
    {
        $this->lists = new ArrayCollection();
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }

        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * @return Collection|TodoList[]
     */
    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(TodoList $list): self
    {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setUser($this);
        }

        return $this;
    }

    public function removeList(TodoList $list): self
    {
        if ($this->lists->contains($list)) {
            $this->lists->removeElement($list);
            // set the owning side to null (unless already changed)
            if ($list->getUser() === $this) {
                $list->setUser(null);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize([
            $this->idUser,
            $this->email,
            $this->password,
            $this->isActive,
                // see section on salt below
                // $this->salt,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list(
                $this->idUser,
                $this->email,
                $this->password,
                $this->isActive,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }


}
