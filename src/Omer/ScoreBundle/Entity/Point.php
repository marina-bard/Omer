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
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Omer\ScoreBundle\Repository\PointRepository")
 * @ORM\Table(name="point")
 */
class Point
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="value", type="integer")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Criterion", inversedBy="points")
     * @ORM\JoinColumn(name="criterion_id", referencedColumnName="id", nullable=TRUE, onDelete="CASCADE")
     */
    protected $criterion;


    /**
     * @ORM\ManyToOne(targetEntity="Score", inversedBy="points")
     * @ORM\JoinColumn(name="score_id", referencedColumnName="id", nullable=TRUE, onDelete="CASCADE")
     */
    protected $score;

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
     * Set value
     *
     * @param integer $value
     *
     * @return Point
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

    /**
     * Set criterion
     *
     * @param \Omer\ScoreBundle\Entity\Criterion $criterion
     *
     * @return Point
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
     * Set score
     *
     * @param \Omer\ScoreBundle\Entity\Score $score
     *
     * @return Point
     */
    public function setScore(\Omer\ScoreBundle\Entity\Score $score = null)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return \Omer\ScoreBundle\Entity\Score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @Assert\Callback()
     */
    public function isValidValue(ExecutionContextInterface $context, $payload)
    {
        if ($this->getCriterion()->getIsBoundaryValues()) {
            if ($this->getValue() != $this->getCriterion()->getMaxValue()
                && $this->getValue() != $this->getCriterion()->getMinValue()) {
                $context->buildViolation('point.value.value_error')
                    ->atPath('value')
                    ->addViolation();
            }
        }
        else {
            if ($this->getValue() < $this->getCriterion()->getMinValue()
                || $this->getValue() > $this->getCriterion()->getMaxValue()) {
                $context->buildViolation('point.value.value_error')
                    ->atPath('value')
                    ->addViolation();
            }
        }
    }
}
