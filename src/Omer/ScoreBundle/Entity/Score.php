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
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Point", mappedBy="score", cascade={"all"})
     */
    protected $points;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $totalScore;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\BaseTeam", inversedBy="scores")
     * @ORM\JoinColumn(name="base_team_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\UserBundle\Entity\OfficialUser", inversedBy="scores")
     * @ORM\JoinColumn(name="judge_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $judge;

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

    /**
     * Set totalScore
     *
     * @param integer $totalScore
     *
     * @return Score
     */
    public function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;

        return $this;
    }

    /**
     * Get totalScore
     *
     * @return integer
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }

    /**
     * Set team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     *
     * @return Score
     */
    public function setTeam(\Omer\TeamBundle\Entity\BaseTeam $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Omer\TeamBundle\Entity\BaseTeam
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set judge
     *
     * @param \Omer\UserBundle\Entity\OfficialUser $judge
     *
     * @return Score
     */
    public function setJudge(\Omer\UserBundle\Entity\OfficialUser $judge = null)
    {
        $this->judge = $judge;

        return $this;
    }

    /**
     * Get judge
     *
     * @return \Omer\UserBundle\Entity\OfficialUser
     */
    public function getJudge()
    {
        return $this->judge;
    }
}
