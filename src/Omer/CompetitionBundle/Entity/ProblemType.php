<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 03.04.17
 * Time: 12:00
 */

namespace Omer\CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="problem_type")
 */

class ProblemType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="number", type="integer")
     */
    protected $number;

    /**
     * @ORM\OneToMany(targetEntity="Omer\CompetitionBundle\Entity\Problem", mappedBy="type")
     */
    protected $problems;
    /**
     * Constructor
     */
    public function __construct($title = null, $number = null)
    {
        $this->title = $title;
        $this->number = $number;
        $this->problems = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return ProblemType
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
     * Add problem
     *
     * @param \Omer\CompetitionBundle\Entity\Problem $problem
     *
     * @return ProblemType
     */
    public function addProblem(\Omer\CompetitionBundle\Entity\Problem $problem)
    {
        $this->problems[] = $problem;

        return $this;
    }

    /**
     * Remove problem
     *
     * @param \Omer\CompetitionBundle\Entity\Problem $problem
     */
    public function removeProblem(\Omer\CompetitionBundle\Entity\Problem $problem)
    {
        $this->problems->removeElement($problem);
    }

    /**
     * Get problems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProblems()
    {
        return $this->problems;
    }

    public function __toString()
    {
        return (string) $this->title;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return ProblemType
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
}
