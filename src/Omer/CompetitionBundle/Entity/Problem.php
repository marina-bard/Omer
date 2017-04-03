<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.02.17
 * Time: 23:39
 */

namespace Omer\CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="problem")
 */
class Problem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\CompetitionBundle\Entity\ProblemType", inversedBy="problems")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Problem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Problem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param \Omer\CompetitionBundle\Entity\ProblemType $type
     *
     * @return Problem
     */
    public function setType(\Omer\CompetitionBundle\Entity\ProblemType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Omer\CompetitionBundle\Entity\ProblemType
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return$this->title;
    }
}
