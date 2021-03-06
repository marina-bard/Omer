<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 06.03.17
 * Time: 16:27
 */

namespace Omer\UserBundle\Entity;


use Omer\TravelBundle\Entity\TravelInfo;
use Omer\UserBundle\Traits\NativeFullName;
use Omer\UserBundle\Traits\PasswordGeneratorTrait;
use Omer\UserBundle\Traits\PersonalDataTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Omer\UserBundle\Repository\OfficialUserRepository")
 * @ORM\Table(name="director_user")
 */
class OfficialUser extends User
{
    use PersonalDataTrait;
    use PasswordGeneratorTrait;
    use NativeFullName;

    const GENDER = [
        'gender.male',
        'gender.female'
    ];

    const ROLES = [
        'role.ad' => 'ROLE_DIRECTOR',
        'role.judge' => 'ROLE_JUDGE',
        'role.driver' => 'ROLE_USER'
    ];

    const PREFERENCES = [
        'problem.vehicle' => 1,
        'problem.technical' => 2,
        'problem.classics' => 3,
        'problem.structure' => 4,
        'problem.performance' => 5,
        'preferences.problem' => 6,
        'preferences.style' => 7,
        'preferences.spontaneous' => 0
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    protected $gender;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(name="mobile_phone", type="string", nullable=true)
     */
    protected $mobilePhone;

    /**
     * @var string
     * @ORM\Column(name="association", type="string", nullable=true)
     */
    protected $association;

    /**
     * @ORM\OneToMany(targetEntity="Language", mappedBy="user", cascade={"all"})
     */
    protected $languages;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TravelBundle\Entity\TravelInfo", mappedBy="user", cascade={"all"})
     */
    protected $travelAttributes;

    /**
     * @var string
     * @ORM\Column(name="dietary_concerns", type="string", nullable=true)
     */
    protected $dietaryConcerns;

    /**
     * @var string
     * @ORM\Column(name="medical_concerns", type="string", nullable=true)
     */
    protected $medicalConcerns;

    /**
     * @var string
     * @ORM\Column(name="job", type="string", nullable=true)
     */
    protected $job;

    /**
     * @var string
     * @ORM\Column(name="position", type="string", nullable=true)
     */
    protected $position;

    /**
     * @ORM\Column(name="preferences", type="array", nullable=true)
     */
    protected $preferences;

    public function __construct()
    {
        parent::__construct();
        $this->setEnabled(true);
        $this->setPlainPassword($this->generatePassword());
        $this->createTravelAttribute(TravelInfo::TYPE['arrivals']);
        $this->createTravelAttribute(TravelInfo::TYPE['departures']);
    }

    public function createTravelAttribute($type)
    {
        $attr = new TravelInfo();
        $attr->setType($type);
        $attr->setUser($this);
        $this->addTravelAttribute($attr);
    }

    public function setEmail($email)
    {
        if (!$this->hasRole('ROLE_SUPER_ADMIN')) {
            $this->setUsername($email);
        }
        return parent::setEmail($email); // TODO: Change the autogenerated stub
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return OfficialUser
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return OfficialUser
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
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return OfficialUser
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set association
     *
     * @param string $association
     *
     * @return OfficialUser
     */
    public function setAssociation($association)
    {
        $this->association = $association;

        return $this;
    }

    /**
     * Get association
     *
     * @return string
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * Set dietaryConcerns
     *
     * @param string $dietaryConcerns
     *
     * @return OfficialUser
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
     * @return OfficialUser
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
     * Add language
     *
     * @param \Omer\UserBundle\Entity\Language $language
     *
     * @return OfficialUser
     */
    public function addLanguage(\Omer\UserBundle\Entity\Language $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param \Omer\UserBundle\Entity\Language $language
     */
    public function removeLanguage(\Omer\UserBundle\Entity\Language $language)
    {
        $this->languages->removeElement($language);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Add travelAttribute
     *
     * @param \Omer\TravelBundle\Entity\TravelInfo $travelAttribute
     *
     * @return OfficialUser
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

    public function __toString()
    {
        return (string) $this->firstName.' '.$this->surname;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return OfficialUser
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return OfficialUser
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set preferences
     *
     * @param array $preferences
     *
     * @return OfficialUser
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;

        return $this;
    }

    /**
     * Get preferences
     *
     * @return array
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    public function getMainRole()
    {
        switch (reset($this->roles)) {
            case 'ROLE_DIRECTOR':
                return 'AD';
            case 'ROLE_JUDGE':
                return 'Judge';
            default:
                return 'User';
        }
    }
}
