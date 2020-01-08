<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Vm
 *
 * @ORM\Table(name="vm")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VmRepository")
 */
class Vm
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
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Serializer\Annotation\Type("string")
     * @Serializer\Groups({"detail", "list"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="os", type="string", length=255)
     * @JMS\Serializer\Annotation\Type("string")
     * @Serializer\Groups({"detail", "list"})
     */
    private $os;

    /**
     * @var int
     *
     * @ORM\Column(name="nbcpu", type="integer")
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $nbcpu;

    /**
     * @var int
     *
     * @ORM\Column(name="currentCpu", type="integer", nullable=true, options={"default":0})
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $currentCpu;

    /**
     * @var int
     *
     * @ORM\Column(name="currentRam", type="integer", nullable=true, options={"default":0})
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $currentRam;

    /**
     * @var int
     *
     * @ORM\Column(name="maxRam", type="integer")
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $maxRam;

    /**
     * @var int
     *
     * @ORM\Column(name="harddisk", type="integer")
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $harddisk;

    /**
     * @var int
     *
     * @ORM\Column(name="currentharddisk", type="integer", nullable=true, options={"default":0})
     * @JMS\Serializer\Annotation\Type("integer")
     * @Serializer\Groups({"detail", "list"})
     */
    private $currentharddisk;
    
    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean", nullable=true, options={"default":true})
     * @JMS\Serializer\Annotation\Type("boolean")
     * @Serializer\Groups({"detail", "list"})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="vms")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Serializer\Groups({"aucun"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Pool", inversedBy="vmsPool")
     * @ORM\JoinColumn(name="pool_id", referencedColumnName="id")
     * @Serializer\Groups({"aucun"})
     * 
     */
    private $pool;

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Vm
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

     /**
     * Set pool.
     *
     * @param Pool $pool
     *
     * @return Vm
     */
    public function setPool($pool)
    {
        $this->pool = $pool;

        return $this;
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
     * Get pool.
     *
     * @return Pool
     */
    public function getPool()
    {
        return $this->pool;
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
     * @return Vm
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
     * Set os.
     *
     * @param string $os
     *
     * @return Vm
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Get os.
     *
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Set nbcpu.
     *
     * @param string $nbcpu
     *
     * @return Vm
     */
    public function setNbcpu($nbcpu)
    {
        $this->nbcpu = $nbcpu;

        return $this;
    }

    /**
     * Get nbcpu.
     *
     * @return string
     */
    public function getNbcpu()
    {
        return $this->nbcpu;
    }

    /**
     * Set currentCpu.
     *
     * @param string $currentCpu
     *
     * @return Vm
     */
    public function setCurrentCpu($currentCpu)
    {
        $this->currentCpu = $currentCpu;

        return $this;
    }

    /**
     * Get currentCpu.
     *
     * @return string
     */
    public function getCurrentCpu()
    {
        return $this->currentCpu;
    }

    /**
     * Set currentRam.
     *
     * @param int $currentRam
     *
     * @return Vm
     */
    public function setCurrentRam($currentRam)
    {
        $this->currentRam = $currentRam;

        return $this;
    }

    /**
     * Get currentRam.
     *
     * @return int
     */
    public function getCurrentRam()
    {
        return $this->currentRam;
    }

    /**
     * Set maxRam.
     *
     * @param int $maxRam
     *
     * @return Vm
     */
    public function setMaxRam($maxRam)
    {
        $this->maxRam = $maxRam;

        return $this;
    }

    /**
     * Get maxRam.
     *
     * @return int
     */
    public function getMaxRam()
    {
        return $this->maxRam;
    }

    /**
     * Set harddisk.
     *
     * @param int $harddisk
     *
     * @return Vm
     */
    public function setHarddisk($harddisk)
    {
        $this->harddisk = $harddisk;

        return $this;
    }

    /**
     * Get harddisk.
     *
     * @return int
     */
    public function getHarddisk()
    {
        return $this->harddisk;
    }

    /**
     * Set currentharddisk.
     *
     * @param int $currentharddisk
     *
     * @return Vm
     */
    public function setCurrentharddisk($currentharddisk)
    {
        $this->currentharddisk = $currentharddisk;

        return $this;
    }

    /**
     * Get currentharddisk.
     *
     * @return int
     */
    public function getCurrentharddisk()
    {
        return $this->currentharddisk;
    }

}
