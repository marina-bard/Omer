<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.02.17
 * Time: 23:21
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="foreign_team")
 *
 */
class ForeignTeam extends BaseTeam
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="school", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $school;

    /**
     * @ORM\Column(name="country", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $country;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\CompetitionBundle\Entity\Problem", inversedBy="teams", cascade={"all"})
     * @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     */
    protected $problem;

    /**
     * @ORM\Column(name="problem", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $division;

    /**
     * @ORM\Column(name="date_of_arrival", type="datetime", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $dateOfArrival;

    /**
     * @ORM\Column(name="date_of_departure", type="datetime", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $dateOfDeparture;


    /**
     * @ORM\Column(name="concerns", type="string", nullable=true)
     *
     */
    protected $concerns;

    /**
     * Set school
     *
     * @param string $school
     *
     * @return ForeignTeam
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return ForeignTeam
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
     * Set address
     *
     * @param string $address
     *
     * @return ForeignTeam
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
     * Set division
     *
     * @param string $division
     *
     * @return ForeignTeam
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set dateOfArrival
     *
     * @param \DateTime $dateOfArrival
     *
     * @return ForeignTeam
     */
    public function setDateOfArrival($dateOfArrival)
    {
        $this->dateOfArrival = $dateOfArrival;

        return $this;
    }

    /**
     * Get dateOfArrival
     *
     * @return \DateTime
     */
    public function getDateOfArrival()
    {
        return $this->dateOfArrival;
    }

    /**
     * Set dateOfDeparture
     *
     * @param \DateTime $dateOfDeparture
     *
     * @return ForeignTeam
     */
    public function setDateOfDeparture($dateOfDeparture)
    {
        $this->dateOfDeparture = $dateOfDeparture;

        return $this;
    }

    /**
     * Get dateOfDeparture
     *
     * @return \DateTime
     */
    public function getDateOfDeparture()
    {
        return $this->dateOfDeparture;
    }

    /**
     * Set concerns
     *
     * @param string $concerns
     *
     * @return ForeignTeam
     */
    public function setConcerns($concerns)
    {
        $this->concerns = $concerns;

        return $this;
    }

    /**
     * Get concerns
     *
     * @return string
     */
    public function getConcerns()
    {
        return $this->concerns;
    }

    /**
     * Set problem
     *
     * @param \Omer\CompetitionBundle\Entity\Problem $problem
     *
     * @return ForeignTeam
     */
    public function setProblem(\Omer\CompetitionBundle\Entity\Problem $problem = null)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return \Omer\CompetitionBundle\Entity\Problem
     */
    public function getProblem()
    {
        return $this->problem;
    }
}
