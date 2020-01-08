<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, unique=true)
     * @JMS\Serializer\Annotation\Type("string")
     * @Serializer\Groups({"detail", "list"})
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * @Serializer\Groups({"aucun"})
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="Vm", mappedBy="user", cascade={"remove"})
     * @Serializer\Groups({"aucun"})
     */
    private $vms;

    /**
     * @ORM\OneToMany(targetEntity="Pool", mappedBy="user", cascade={"remove"})
     * @Serializer\Groups({"aucun"})
     */
    private $pools;

    public function __construct()
    {
        $this->pools = new ArrayCollection();
        $this->vms = new ArrayCollection();
        $this->role = new Role();
    }
    
    /**
     * @return Collection|Pool[]
     */
    public function getPools(): Collection
    {
        return $this->pools;
    }

    /**
     * @return Collection|Vm[]
     */
    public function getVms(): Collection
    {
        return $this->vms;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role.
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
