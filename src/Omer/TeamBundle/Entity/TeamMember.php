<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omer\UserBundle\Traits\PersonalDataTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_member")
 */
class TeamMember
{
    use PersonalDataTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\BaseTeam", inversedBy="members", cascade={"persist"})
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="cascade")
     */
    private $team;

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
     * Set team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     *
     * @return TeamMember
     */
    public function setTeam(\Omer\TeamBundle\Entity\BaseTeam $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Omer\TeamBundle\Entity\BaseTeam
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set dietaryConcerns
     *
     * @param string $dietaryConcerns
     *
     * @return TeamMember
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
     * @return TeamMember
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
     * @return TeamMember
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
