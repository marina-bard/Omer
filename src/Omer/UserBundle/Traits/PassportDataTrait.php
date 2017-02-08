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

trait PassportDataTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="latin_surname", type="string", nullable=true)
     */
    protected $latinSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="latin_name", type="string", nullable=true)
     */
    protected $latinName;

    /**
     * @var string
     *
     * @ORM\Column(name="latin_patronymic", type="string", nullable=true)
     */
    protected $latinPatronymic;

    public function setLatinSurname($latinSurname)
    {
        $this->latinSurname = $latinSurname;

        return $this;
    }

    public function getLatinSurname()
    {
        return $this->latinSurname;
    }

    public function setLatinName($latinName)
    {
        $this->latinName = $latinName;

        return $this;
    }

    public function getLatinName()
    {
        return $this->latinName;
    }

    public function setLatinPatronymic($latinPatronymic)
    {
        $this->latinPatronymic = $latinPatronymic;

        return $this;
    }

    public function getLatinPatronymic()
    {
        return $this->latinPatronymic;
    }

}