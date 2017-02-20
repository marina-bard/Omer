<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Base;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="base_team")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="team_type", type="string")
 * @ORM\DiscriminatorMap({"native_team" = "NativeTeam", "foreign_team" = "ForeignTeam"})
 */

abstract class BaseTeam
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="english_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $englishTeamName;

    /**
     * @ORM\Column(name="member_number", type="integer", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $memberNumber;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Omer\UserBundle\Entity\CoachUser", inversedBy="teams", cascade={"all"})
     * @ORM\JoinTable(name="coaches_teams")
     */
    protected $coaches;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\TeamMember", mappedBy="team", cascade={"all"})
     */
    protected $members;

    /**
     * @ORM\Column(name="city", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $city;

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
     * Add member
     *
     * @param \Omer\TeamBundle\Entity\TeamMember $member
     *
     * @return BaseTeam
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

    public function getMainCoach()
    {
        foreach ($this->coaches as $coach) {
            if ($coach->getIsMain()) {
                return $coach;
            }
        }
    }

    /**
     * Add coach
     *
     * @param \Omer\UserBundle\Entity\CoachUser $coach
     *
     * @return BaseTeam
     */
    public function addCoach(\Omer\UserBundle\Entity\CoachUser $coach)
    {
        $this->coaches[] = $coach;

        return $this;
    }

    /**
     * Remove coach
     *
     * @param \Omer\UserBundle\Entity\CoachUser $coach
     */
    public function removeCoach(\Omer\UserBundle\Entity\CoachUser $coach)
    {
        $this->coaches->removeElement($coach);
    }

    /**
     * Get coaches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoaches()
    {
        return $this->coaches;
    }

    public function setCoaches($coaches)
    {
        if (count($coaches) > 0) {
            foreach ($coaches as $coach) {
                $this->addCoach($coach);
            }
        }
        return $this;
    }

    public function setMembers($members)
    {
        $this->members = new ArrayCollection();
        if (count($members) > 0) {
            foreach ($members as $member) {
                $this->addMember($member);
            }
        }
        return $this;
    }

    /**
     * Set englishTeamName
     *
     * @param string $englishTeamName
     *
     * @return BaseTeam
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
     * @return BaseTeam
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
     * Set city
     *
     * @param string $city
     *
     * @return BaseTeam
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}
