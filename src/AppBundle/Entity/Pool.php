<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Pool
 *
 * @ORM\Table(name="pool")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PoolRepository")
 */
class Pool
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"detail", "list"})
     * @Assert\NotBlank(groups={"Create"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Vm", mappedBy="pool" ,cascade={"persist"})
     */

    private $vmsPool;

    public function __construct()
    {
        $this->vmsPool = new ArrayCollection();
    }
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pools")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return Collection|Vm[]
     */
    public function getVmsPool(): Collection
    {
        return $this->vmsPool;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Pool
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Pool
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    
}
