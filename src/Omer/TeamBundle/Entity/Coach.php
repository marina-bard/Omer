<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 19:41
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omer\UserBundle\Traits\PersonalDataTrait;
use Omer\UserBundle\Traits\PasswordGeneratorTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="coach")
 */
class Coach
{
    use PasswordGeneratorTrait;
    use PersonalDataTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(name="dietary_concerns", type="string", nullable=true)
     */
    private $dietaryConcerns;

    /**
     * @var string
     * @ORM\Column(name="medical_concerns", type="string", nullable=true)
     */
    private $medicalConcerns;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="Omer\TeamBundle\Entity\BaseTeam", mappedBy="coaches")
     */
    protected $teams;

    /**
     * Add team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     *
     * @return Coach
     */
    public function addTeam(\Omer\TeamBundle\Entity\BaseTeam $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     */
    public function removeTeam(\Omer\TeamBundle\Entity\BaseTeam $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Coach
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dietaryConcerns
     *
     * @param string $dietaryConcerns
     *
     * @return Coach
     */
    public function setDietaryConcerns($dietaryConcerns)
    {
        $this->dietaryConcerns = $dietaryConcerns;

        return $this;
    }

    /**
     * Get dietaryConcerns
     *
     * @return string
     */
    public function getDietaryConcerns()
    {
        return $this->dietaryConcerns;
    }

    /**
     * Set medicalConcerns
     *
     * @param string $medicalConcerns
     *
     * @return Coach
     */
    public function setMedicalConcerns($medicalConcerns)
    {
        $this->medicalConcerns = $medicalConcerns;

        return $this;
    }

    /**
     * Get medicalConcerns
     *
     * @return string
     */
    public function getMedicalConcerns()
    {
        return $this->medicalConcerns;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Coach
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
