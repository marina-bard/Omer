<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="native_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $nativeTeamName;

    /**
     * @ORM\Column(name="english_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $englishTeamName;

    /**
     * @ORM\Column(name="member_number", type="integer", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $memberNumber;

    /**
     * @ORM\Column(name="guo", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $guo;

    /**
     * @ORM\Column(name="guo_address", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $guoAddress;

    /**
     * @ORM\Column(name="principal_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $principalFullName;

    /**
     * @ORM\Column(name="education_department", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $educationDepartment;

    /**
     * @ORM\Column(name="education_department_address", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $educationDepartmentAddress;

    /**
     * @ORM\Column(name="head_of_edu_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $headOfEduFullName;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\UserBundle\Entity\CoachUser", inversedBy="teams", cascade={"persist"})
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id", onDelete="cascade")
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\TeamMember", mappedBy="team", cascade={"all"})
     */
    protected $members;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nativeTeamName
     *
     * @param string $nativeTeamName
     *
     * @return Team
     */
    public function setNativeTeamName($nativeTeamName)
    {
        $this->nativeTeamName = $nativeTeamName;

        return $this;
    }

    /**
     * Get nativeTeamName
     *
     * @return string
     */
    public function getNativeTeamName()
    {
        return $this->nativeTeamName;
    }

    /**
     * Set englishTeamName
     *
     * @param string $englishTeamName
     *
     * @return Team
     */
    public function setEnglishTeamName($englishTeamName)
    {
        $this->englishTeamName = $englishTeamName;

        return $this;
    }

    /**
     * Get englishTeamName
     *
     * @return string
     */
    public function getEnglishTeamName()
    {
        return $this->englishTeamName;
    }

    /**
     * Set memberNumber
     *
     * @param integer $memberNumber
     *
     * @return Team
     */
    public function setMemberNumber($memberNumber)
    {
        $this->memberNumber = $memberNumber;

        return $this;
    }

    /**
     * Get memberNumber
     *
     * @return integer
     */
    public function getMemberNumber()
    {
        return $this->memberNumber;
    }

    /**
     * Set guo
     *
     * @param string $guo
     *
     * @return Team
     */
    public function setGuo($guo)
    {
        $this->guo = $guo;

        return $this;
    }

    /**
     * Get guo
     *
     * @return string
     */
    public function getGuo()
    {
        return $this->guo;
    }

    /**
     * Set guoAddress
     *
     * @param string $guoAddress
     *
     * @return Team
     */
    public function setGuoAddress($guoAddress)
    {
        $this->guoAddress = $guoAddress;

        return $this;
    }

    /**
     * Get guoAddress
     *
     * @return string
     */
    public function getGuoAddress()
    {
        return $this->guoAddress;
    }

    /**
     * Set principalFullName
     *
     * @param string $principalFullName
     *
     * @return Team
     */
    public function setPrincipalFullName($principalFullName)
    {
        $this->principalFullName = $principalFullName;

        return $this;
    }

    /**
     * Get principalFullName
     *
     * @return string
     */
    public function getPrincipalFullName()
    {
        return $this->principalFullName;
    }

    /**
     * Set educationDepartment
     *
     * @param string $educationDepartment
     *
     * @return Team
     */
    public function setEducationDepartment($educationDepartment)
    {
        $this->educationDepartment = $educationDepartment;

        return $this;
    }

    /**
     * Get educationDepartment
     *
     * @return string
     */
    public function getEducationDepartment()
    {
        return $this->educationDepartment;
    }

    /**
     * Set headOfEduFullName
     *
     * @param string $headOfEduFullName
     *
     * @return Team
     */
    public function setHeadOfEduFullName($headOfEduFullName)
    {
        $this->headOfEduFullName = $headOfEduFullName;

        return $this;
    }

    /**
     * Get headOfEduFullName
     *
     * @return string
     */
    public function getHeadOfEduFullName()
    {
        return $this->headOfEduFullName;
    }

    /**
     * Set coach
     *
     * @param \Omer\UserBundle\Entity\CoachUser $coach
     *
     * @return Team
     */
    public function setCoach(\Omer\UserBundle\Entity\CoachUser $coach = null)
    {
        $this->coach = $coach;
        $coach->addTeam($this);

        return $this;
    }

    /**
     * Get coach
     *
     * @return \Omer\UserBundle\Entity\CoachUser
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Add member
     *
     * @param \Omer\TeamBundle\Entity\TeamMember $member
     *
     * @return Team
     */
    public function addMember(\Omer\TeamBundle\Entity\TeamMember $member)
    {
        $this->members[] = $member;
        $member->setTeam($this);

        return $this;
    }

    /**
     * Remove member
     *
     * @param \Omer\TeamBundle\Entity\TeamMember $member
     */
    public function removeMember(\Omer\TeamBundle\Entity\TeamMember $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set educationDepartmentAddress
     *
     * @param string $educationDepartmentAddress
     *
     * @return Team
     */
    public function setEducationDepartmentAddress($educationDepartmentAddress)
    {
        $this->educationDepartmentAddress = $educationDepartmentAddress;

        return $this;
    }

    /**
     * Get educationDepartmentAddress
     *
     * @return string
     */
    public function getEducationDepartmentAddress()
    {
        return $this->educationDepartmentAddress;
    }
}
