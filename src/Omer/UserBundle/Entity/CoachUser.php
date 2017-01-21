<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 21.01.17
 * Time: 19:41
 */

namespace Omer\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="coach_user")
 */
class CoachUser extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    protected $surname;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    protected $name;

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
     * @Assert\NotBlank(
     *     message="value is invalid(field must be non empty)",
     *     )
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    protected $phone;
}