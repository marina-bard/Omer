<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="base_team")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="team_type", type="string")
 * @ORM\DiscriminatorMap({"foreign_team" = "ForeignTeam"})
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
     * @ORM\ManyToMany(targetEntity="Omer\TeamBundle\Entity\Coach", inversedBy="teams", cascade={"all"})
     * @ORM\JoinTable(name="coaches_teams")
     */
    protected $coaches;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\TeamMember", mappedBy="team", cascade={"all"})
     */
    protected $members;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\OtherPeople", mappedBy="team", cascade={"all"})
     */
    protected $otherPeople;

    /**
     * @ORM\Column(name="city", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $city;

    /**
     * @ORM\Column(name="country", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $country;

    /**
     * @ORM\Column(name="district", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $district;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->coaches = new ArrayCollection();
        $this->otherPeople = new ArrayCollection();
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
        $member->setTeam(null);
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
     * Add coach
     *
     * @param \Omer\TeamBundle\Entity\Coach $coach
     *
     * @return BaseTeam
     */
    public function addCoach(\Omer\TeamBundle\Entity\Coach $coach)
    {
        $this->coaches[] = $coach;

        return $this;
    }

    /**
     * Remove coach
     *
     * @param \Omer\TeamBundle\Entity\Coach $coach
     */
    public function removeCoach(\Omer\TeamBundle\Entity\Coach $coach)
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

    /**
     * Set country
     *
     * @param string $country
     *
     * @return BaseTeam
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add otherPerson
     *
     * @param \Omer\TeamBundle\Entity\OtherPeople $otherPerson
     *
     * @return BaseTeam
     */
    public function addOtherPerson(\Omer\TeamBundle\Entity\OtherPeople $otherPerson)
    {
        $this->otherPeople[] = $otherPerson;
        $otherPerson->setTeam($this);

        return $this;
    }

    /**
     * Remove otherPerson
     *
     * @param \Omer\TeamBundle\Entity\OtherPeople $otherPerson
     */
    public function removeOtherPerson(\Omer\TeamBundle\Entity\OtherPeople $otherPerson)
    {
        $this->otherPeople->removeElement($otherPerson);
        $otherPerson->setTeam(null);
    }

    /**
     * Get otherPeople
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtherPeople()
    {
        return $this->otherPeople;
    }

    public function setOtherPeople($other)
    {
        $this->otherPeople = new ArrayCollection();
        if (count($other) > 0) {
            foreach ($other as $item) {
                $this->addOtherPerson($item);
            }
        }
        return $this;
    }

    /**
     * Set district
     *
     * @param string $district
     *
     * @return BaseTeam
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    public function __toString()
    {
        return $this->englishTeamName;
    }
}
