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
     */
    protected $school;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     *
     */
    protected $address;

//    /**
//     * @ORM\ManyToOne(targetEntity="Omer\CompetitionBundle\Entity\Problem", inversedBy="teams", cascade={"all"})
//     * @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
//     */
    /**
     * @ORM\Column(name="problem", type="string", nullable=true)
     *
     */
    protected $problem;

    /**
     * @ORM\Column(name="division", type="string", nullable=true)
     *
     */
    protected $division;

    /**
     * @ORM\Column(name="date_of_arrival", type="date", nullable=true)
     *
     *
     */
    protected $dateOfArrival;

    /**
     * @ORM\Column(name="date_of_departure", type="date", nullable=true)
     */
    protected $dateOfDeparture;

    /**
     * @ORM\Column(name="concerns", type="string", nullable=true)
     *
     */
    protected $concerns;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_currency", type="string", nullable=true)
     */
    protected $paymentCurrency;

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
        $this->dateOfArrival->format('d-m-Y');

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
        $this->dateOfDeparture->format('d-m-Y');

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
     * Set dictrict
     *
     * @param string $dictrict
     *
     * @return ForeignTeam
     */
    public function setDictrict($dictrict)
    {
        $this->dictrict = $dictrict;

        return $this;
    }

    /**
     * Get dictrict
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set problem
     *
     * @param string $problem
     *
     * @return ForeignTeam
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Set paymentCurrency
     *
     * @param string $paymentCurrency
     *
     * @return ForeignTeam
     */
    public function setPaymentCurrency($paymentCurrency)
    {
        $this->paymentCurrency = $paymentCurrency;

        return $this;
    }

    /**
     * Get paymentCurrency
     *
     * @return string
     */
    public function getPaymentCurrency()
    {
        return $this->paymentCurrency;
    }
}
