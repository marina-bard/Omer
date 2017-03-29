<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.03.17
 * Time: 16:08
 */

namespace Omer\UserBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait NativeFullName
{
    /**
     * @var string
     *
     * @ORM\Column(name="native_first_name", type="string", nullable=true)
     */
    protected $nativeFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="native_surname", type="string", nullable=true)
     */
    protected $nativeSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="native_patronymic", type="string", nullable=true)
     */
    protected $nativePatronymic;

    /**
     * @param string $nativeFirstName
     */
    public function setNativeFirstName($nativeFirstName)
    {
        $this->nativeFirstName = $nativeFirstName;
    }

    /**
     * @return string
     */
    public function getNativeFirstName()
    {
        return $this->nativeFirstName;
    }

    /**
     * @param string $nativeSurname
     */
    public function setNativeSurname($nativeSurname)
    {
        $this->nativeSurname = $nativeSurname;
    }

    /**
     * @return string
     */
    public function getNativeSurname()
    {
        return $this->nativeSurname;
    }

    /**
     * @param string $nativePatronymic
     */
    public function setNativePatronymic($nativePatronymic)
    {
        $this->nativePatronymic = $nativePatronymic;
    }

    /**
     * @return string
     */
    public function getNativePatronymic()
    {
        return $this->nativePatronymic;
    }

}