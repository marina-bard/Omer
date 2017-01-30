<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omer\UserBundle\Traits\FullNameTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_member")
 */
class TeamMember
{
    use FullNameTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    private $patronymic;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     * @ORM\Column(name="allergy", type="string", nullable=true)
     */
    private $allergy;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\Team", inversedBy="members")
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
     * Set surname
     *
     * @param string $surname
     *
     * @return TeamMember
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TeamMember
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     *
     * @return TeamMember
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * Get patronymic
     *
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return TeamMember
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set allergy
     *
     * @param string $allergy
     *
     * @return TeamMember
     */
    public function setAllergy($allergy)
    {
        $this->allergy = $allergy;

        return $this;
    }

    /**
     * Get allergy
     *
     * @return string
     */
    public function getAllergy()
    {
        return $this->allergy;
    }

    /**
     * Set team
     *
     * @param \Omer\TeamBundle\Entity\Team $team
     *
     * @return TeamMember
     */
    public function setTeam(\Omer\TeamBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Omer\TeamBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    public function __toString()
    {
       return $this->getFullName([
           $this->surname,
           $this->name,
           $this->patronymic
       ]);
    }
}
