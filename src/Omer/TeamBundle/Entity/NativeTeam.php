<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.02.17
 * Time: 23:22
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="native_team")
 *
 */
class NativeTeam extends BaseTeam
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="native_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $nativeTeamName;

    /**
     * @ORM\Column(name="guo", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $guo;

    /**
     * @ORM\Column(name="guo_address", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $guoAddress;

    /**
     * @ORM\Column(name="principal_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $principalFullName;

    /**
     * @ORM\Column(name="education_department", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $educationDepartment;

    /**
     * @ORM\Column(name="education_department_address", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $educationDepartmentAddress;

    /**
     * @ORM\Column(name="head_of_edu_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    protected $headOfEduFullName;

    public function __toString()
    {
        $this->nativeTeamName;
    }


    /**
     * Set nativeTeamName
     *
     * @param string $nativeTeamName
     *
     * @return NativeTeam
     */
    public function setNativeTeamName($nativeTeamName)
    {
        $this->nativeTeamName = $nativeTeamName;

        return $this;
    }

    /**
     * Get nativeTeamName
     *
     * @return string
     */
    public function getNativeTeamName()
    {
        return $this->nativeTeamName;
    }

    /**
     * Set guo
     *
     * @param string $guo
     *
     * @return NativeTeam
     */
    public function setGuo($guo)
    {
        $this->guo = $guo;

        return $this;
    }

    /**
     * Get guo
     *
     * @return string
     */
    public function getGuo()
    {
        return $this->guo;
    }

    /**
     * Set guoAddress
     *
     * @param string $guoAddress
     *
     * @return NativeTeam
     */
    public function setGuoAddress($guoAddress)
    {
        $this->guoAddress = $guoAddress;

        return $this;
    }

    /**
     * Get guoAddress
     *
     * @return string
     */
    public function getGuoAddress()
    {
        return $this->guoAddress;
    }

    /**
     * Set principalFullName
     *
     * @param string $principalFullName
     *
     * @return NativeTeam
     */
    public function setPrincipalFullName($principalFullName)
    {
        $this->principalFullName = $principalFullName;

        return $this;
    }

    /**
     * Get principalFullName
     *
     * @return string
     */
    public function getPrincipalFullName()
    {
        return $this->principalFullName;
    }

    /**
     * Set educationDepartment
     *
     * @param string $educationDepartment
     *
     * @return NativeTeam
     */
    public function setEducationDepartment($educationDepartment)
    {
        $this->educationDepartment = $educationDepartment;

        return $this;
    }

    /**
     * Get educationDepartment
     *
     * @return string
     */
    public function getEducationDepartment()
    {
        return $this->educationDepartment;
    }

    /**
     * Set educationDepartmentAddress
     *
     * @param string $educationDepartmentAddress
     *
     * @return NativeTeam
     */
    public function setEducationDepartmentAddress($educationDepartmentAddress)
    {
        $this->educationDepartmentAddress = $educationDepartmentAddress;

        return $this;
    }

    /**
     * Get educationDepartmentAddress
     *
     * @return string
     */
    public function getEducationDepartmentAddress()
    {
        return $this->educationDepartmentAddress;
    }

    /**
     * Set headOfEduFullName
     *
     * @param string $headOfEduFullName
     *
     * @return NativeTeam
     */
    public function setHeadOfEduFullName($headOfEduFullName)
    {
        $this->headOfEduFullName = $headOfEduFullName;

        return $this;
    }

    /**
     * Get headOfEduFullName
     *
     * @return string
     */
    public function getHeadOfEduFullName()
    {
        return $this->headOfEduFullName;
    }
}
