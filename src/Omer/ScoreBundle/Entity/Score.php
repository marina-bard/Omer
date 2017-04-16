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
 * @ORM\Entity(repositoryClass="Omer\ScoreBundle\Repository\ScoreRepository")
 * @ORM\Table(name="score")
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Criterion", inversedBy="points")
     * @ORM\JoinColumn(name="criterion_id", referencedColumnName="id", nullable=TRUE, onDelete="CASCADE")
     */
    protected $criterion;

    /**
    * @ORM\OneToMany(targetEntity="Point", mappedBy="score", cascade={"all"})
    */
    protected $points;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->points = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set criterion
     *
     * @param \Omer\ScoreBundle\Entity\Criterion $criterion
     *
     * @return Score
     */
    public function setCriterion(\Omer\ScoreBundle\Entity\Criterion $criterion = null)
    {
        $this->criterion = $criterion;

        return $this;
    }

    /**
     * Get criterion
     *
     * @return \Omer\ScoreBundle\Entity\Criterion
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Add point
     *
     * @param \Omer\ScoreBundle\Entity\Point $point
     *
     * @return Score
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
