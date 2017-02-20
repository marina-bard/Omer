<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 23:47
 */

namespace Omer\UserBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Omer\UserBundle\Entity\CoachUser;

trait PersonalDataTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="passport_surname", type="string", nullable=true)
     */
    protected $passportSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    protected $firstName;

    public function setPassportSurname($passportSurname)
    {
        $this->passportSurname = $passportSurname;
        return $this;
    }

    public function getPassportSurname()
    {
        return $this->passportSurname;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
}