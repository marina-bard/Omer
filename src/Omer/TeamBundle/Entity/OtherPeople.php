<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.02.17
 * Time: 22:11
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omer\UserBundle\Traits\PersonalDataTrait;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="other_people")
 */
class OtherPeople
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
     * @ORM\Column(name="team_role", type="string", nullable=true)
     */
    private $teamRole;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    private $email;

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
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\BaseTeam", inversedBy="members")
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
     * Set teamRole
     *
     * @param string $teamRole
     *
     * @return OtherPeople
     */
    public function setTeamRole($teamRole)
    {
        $this->teamRole = $teamRole;

        return $this;
    }

    /**
     * Get teamRole
     *
     * @return string
     */
    public function getTeamRole()
    {
        return $this->teamRole;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return OtherPeople
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
     * @return OtherPeople
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
     * @return OtherPeople
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
     * @return OtherPeople
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

    /**
     * Set team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     *
     * @return OtherPeople
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
}
