<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 06.04.17
 * Time: 22:59
 */

namespace Omer\CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="division")
 */
class Division
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
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    protected $number;

    /**
     * @ORM\OneToMany(targetEntity="Omer\TeamBundle\Entity\BaseTeam", mappedBy="division")
     */
    protected $teams;

    /**
     * Constructor
     */
    public function __construct($title, $number)
    {
        $this->title = $title;
        $this->number = $number;
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Division
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
     * Set number
     *
     * @param integer $number
     *
     * @return Division
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

    public function __toString()
    {
        return (string) $this->title;
    }

    /**
     * Add team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     *
     * @return Division
     */
    public function addTeam(\Omer\TeamBundle\Entity\BaseTeam $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \Omer\TeamBundle\Entity\BaseTeam $team
     */
    public function removeTeam(\Omer\TeamBundle\Entity\BaseTeam $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
