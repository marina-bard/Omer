<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 19:41
 */

namespace Omer\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="coach_user")
 */
class CoachUser extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    protected $surname;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    protected $patronymic;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\Team", mappedBy="coach", cascade={"all"})
     */
    protected $teams;

    /**
     * @ORM\Column(name="password", type="string", nullable=true)
     */
    protected $password;

    public function __construct()
    {
        parent::__construct();
    }

    public function setEmail($email)
    {
        $this->setUsername($email);
        return parent::setEmail($email); // TODO: Change the autogenerated stub
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return CoachUser
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
     * @return CoachUser
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
     * @return CoachUser
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
     * Set phone
     *
     * @param string $phone
     *
     * @return CoachUser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add team
     *
     * @param \Omer\TeamBundle\Entity\Team $team
     *
     * @return CoachUser
     */
    public function addTeam(\Omer\TeamBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \Omer\TeamBundle\Entity\Team $team
     */
    public function removeTeam(\Omer\TeamBundle\Entity\Team $team)
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
}