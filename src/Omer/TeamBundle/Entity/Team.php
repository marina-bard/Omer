<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="native_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $nativeTeamName;

    /**
     * @ORM\Column(name="english_team_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $englishTeamName;

    /**
     * @ORM\Column(name="member_number", type="integer", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $memberNumber;

    /**
     * @ORM\Column(name="guo", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $guo;

    /**
     * @ORM\Column(name="guo_adress", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $guoAdress;

    /**
     * @ORM\Column(name="principal_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $principalFullName;

    /**
     * @ORM\Column(name="education_department", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $educationDepartment;

    /**
     * @ORM\Column(name="educatuion_department_adress", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $educatuionDepartmentAdress;

    /**
     * @ORM\Column(name="head_of_edu_full_name", type="string", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     */
    private $headOfEduFullName;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\UserBundle\Entity\CoachUser", inversedBy="teams")
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id", onDelete="cascade")
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\TeamMember", mappedBy="team", cascade={"all"})
     */
    protected $members;
}