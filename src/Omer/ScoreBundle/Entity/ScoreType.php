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
 * @ORM\Entity()
 * @ORM\Table(name="score_type")
 */
class ScoreType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * @ORM\OneToMany(targetEntity="Criterion", mappedBy="scoreType", cascade={"all"})
     */
    protected $criterions;
    /**
     * Constructor
     */
    public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
        $this->criterions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param string $type
     *
     * @return ScoreType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add criterion
     *
     * @param \Omer\ScoreBundle\Entity\Criterion $criterion
     *
     * @return ScoreType
     */
    public function addCriterion(\Omer\ScoreBundle\Entity\Criterion $criterion)
    {
        $this->criterions[] = $criterion;

        return $this;
    }

    /**
     * Remove criterion
     *
     * @param \Omer\ScoreBundle\Entity\Criterion $criterion
     */
    public function removeCriterion(\Omer\ScoreBundle\Entity\Criterion $criterion)
    {
        $this->criterions->removeElement($criterion);
    }

    /**
     * Get criterions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCriterions()
    {
        return $this->criterions;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return ScoreType
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->type;
    }
}
