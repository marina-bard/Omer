<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 11.04.17
 * Time: 22:59
 */

namespace Omer\ScoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="Omer\ScoreBundle\Repository\CriterionRepository")
 * @ORM\Table(name="criterion")
 */
class Criterion implements ORMBehaviors\Tree\NodeInterface,  \ArrayAccess
{
    use ORMBehaviors\Tree\Node;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="min_value", type="integer", nullable=true)
     */
    protected $minValue;

    /**
     * @var string
     * @ORM\Column(name="max_value", type="integer", nullable=true)
     */
    protected $maxValue;

    /**
     * @var string
     * @ORM\Column(name="is_boundary_values", type="boolean", nullable=true)
     */
    protected $isBoundaryValues;

    /**
    * @ORM\OneToMany(targetEntity="Point", mappedBy="criterion", cascade={"all"})
    */
    protected $points;

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
     * @return Criterion
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
     * Set minValue
     *
     * @param integer $minValue
     *
     * @return Criterion
     */
    public function setMinValue($minValue)
    {
        $this->minValue = $minValue;

        return $this;
    }

    /**
     * Get minValue
     *
     * @return integer
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * Set maxValue
     *
     * @param integer $maxValue
     *
     * @return Criterion
     */
    public function setMaxValue($maxValue)
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    /**
     * Get maxValue
     *
     * @return integer
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * Set isBoundaryValues
     *
     * @param boolean $isBoundaryValues
     *
     * @return Criterion
     */
    public function setIsBoundaryValues($isBoundaryValues)
    {
        $this->isBoundaryValues = $isBoundaryValues;

        return $this;
    }

    /**
     * Get isBoundaryValues
     *
     * @return boolean
     */
    public function getIsBoundaryValues()
    {
        return $this->isBoundaryValues;
    }

    public function __toString()
    {
        return (string) $this->title;
     }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->points = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add point
     *
     * @param \Omer\ScoreBundle\Entity\Point $point
     *
     * @return Criterion
     */
    public function addPoint(\Omer\ScoreBundle\Entity\Point $point)
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * Remove point
     *
     * @param \Omer\ScoreBundle\Entity\Point $point
     */
    public function removePoint(\Omer\ScoreBundle\Entity\Point $point)
    {
        $this->points->removeElement($point);
    }

    /**
     * Get points
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoints()
    {
        return $this->points;
    }
}
