<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.02.17
 * Time: 20:58
 */

namespace Omer\UserBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PersonalDataTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    protected $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    protected $firstName;

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
     * @ORM\Column(name="t_shirt_size", type="string", nullable=true)
     */
    protected $T_shirtSize;

    /**
     * @var string
     *
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     */
    protected $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="passport_number", type="string", nullable=true)
     */
    protected $passportNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="date_of_issue", type="date", nullable=true)
     */
    protected $dateOfIssue;

    /**
     * @var string
     *
     * @ORM\Column(name="date_of_expiry", type="date", nullable=true)
     */
    protected $dateOfExpiry;

    /**
     * @var string
     *
     * @ORM\Column(name="citizenship", type="string", nullable=true)
     */
    protected $citizenship;

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->surname;
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return PersonalDataTrait
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return PersonalDataTrait
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     *
     * @return PersonalDataTrait
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
     * Set tShirtSize
     *
     * @param string $tShirtSize
     *
     * @return PersonalDataTrait
     */
    public function setTShirtSize($tShirtSize)
    {
        $this->T_shirtSize = $tShirtSize;

        return $this;
    }

    /**
     * Get tShirtSize
     *
     * @return string
     */
    public function getTShirtSize()
    {
        return $this->T_shirtSize;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return PersonalDataTrait
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set passportNumber
     *
     * @param string $passportNumber
     *
     * @return PersonalDataTrait
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;

        return $this;
    }

    /**
     * Get passportNumber
     *
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * Set dateOfIssue
     *
     * @param \DateTime $dateOfIssue
     *
     * @return PersonalDataTrait
     */
    public function setDateOfIssue($dateOfIssue)
    {
        $this->dateOfIssue = $dateOfIssue;

        return $this;
    }

    /**
     * Get dateOfIssue
     *
     * @return \DateTime
     */
    public function getDateOfIssue()
    {
        return $this->dateOfIssue;
    }

    /**
     * Set dateOfExpiry
     *
     * @param \DateTime $dateOfExpiry
     *
     * @return PersonalDataTrait
     */
    public function setDateOfExpiry($dateOfExpiry)
    {
        $this->dateOfExpiry = $dateOfExpiry;

        return $this;
    }

    /**
     * Get dateOfExpiry
     *
     * @return \DateTime
     */
    public function getDateOfExpiry()
    {
        return $this->dateOfExpiry;
    }

    /**
     * Set citizenship
     *
     * @param string $citizenship
     *
     * @return PersonalDataTrait
     */
    public function setCitizenship($citizenship)
    {
        $this->citizenship = $citizenship;

        return $this;
    }

    /**
     * Get citizenship
     *
     * @return string
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }
}
