<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 21:26
 */

namespace Omer\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_member")
 */
class TeamMember
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    private $patronymic;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     * @ORM\Column(name="allergy", type="string", nullable=true)
     */
    private $allergy;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\Team", inversedBy="members")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="cascade")
     */
    private $team;
}