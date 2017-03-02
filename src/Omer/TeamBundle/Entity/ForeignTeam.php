<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.02.17
 * Time: 23:21
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omer\TravelBundle\Entity\TravelInfo;

/**
 * @ORM\Entity
 * @ORM\Table(name="foreign_team")
 *
 */
class ForeignTeam extends BaseTeam
{
    const PAYMENT_CURRENCY = [
        'BYN',
        'RUB',
        'EUR',
        'USD'
    ];

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
     * @ORM\OneToMany(targetEntity="Omer\TravelBundle\Entity\TravelInfo", mappedBy="team", cascade={"all"})
     */
    protected $travelAttributes;

    public function __construct()
    {
        parent::__construct();
        $this->createTravelAttribute(TravelInfo::TYPE['arrivals']);
        $this->createTravelAttribute(TravelInfo::TYPE['departures']);
    }

    public function createTravelAttribute($type)
    {
        $attr = new TravelInfo();
        $attr->setType($type);
        $attr->setTeam($this);
        $this->addTravelAttribute($attr);
    }

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
        $key = $this->paymentCurrency;
        if ($key !== null) {
            return self::PAYMENT_CURRENCY[$key];
        }
    }

    /**
     * Add travelAttribute
     *
     * @param \Omer\TravelBundle\Entity\TravelInfo $travelAttribute
     *
     * @return ForeignTeam
     */
    public function addTravelAttribute(\Omer\TravelBundle\Entity\TravelInfo $travelAttribute)
    {
        $this->travelAttributes[] = $travelAttribute;

        return $this;
    }

    /**
     * Remove travelAttribute
     *
     * @param \Omer\TravelBundle\Entity\TravelInfo $travelAttribute
     */
    public function removeTravelAttribute(\Omer\TravelBundle\Entity\TravelInfo $travelAttribute)
    {
        $this->travelAttributes->removeElement($travelAttribute);
    }

    /**
     * Get travelAttributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravelAttributes()
    {
        return $this->travelAttributes;
    }
}
