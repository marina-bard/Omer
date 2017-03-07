<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 02.03.17
 * Time: 1:02
 */

namespace Omer\TravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="travel_info")
 * @ORM\Entity()
 */
class TravelInfo
{
    const TYPE = [
        'arrivals' => 0,
        'departures' => 1
    ];

    const TRANSPORT = [
        'label.transport.plane',
        'label.transport.train',
        'label.transport.bus',
        'label.transport.own'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(name="go_by", type="integer", nullable=true)
     */
    private $goBy;

    /**
     * @ORM\Column(name="transport_number", type="string", nullable=true)
     */
    private $transportNumber;

    /**
     * @ORM\Column(name="station_from", type="string", nullable=true)
     */
    private $stationFrom;

    /**
     * @ORM\Column(name="station_to", type="string", nullable=true)
     */
    private $stationTo;

    /**
     * @ORM\Column(name="time", type="string", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\TeamBundle\Entity\ForeignTeam", inversedBy="travelAttributes")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="Omer\UserBundle\Entity\User", inversedBy="travelAttributes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return TravelInfo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set goBy
     *
     * @param integer $goBy
     *
     * @return TravelInfo
     */
    public function setGoBy($goBy)
    {
        $this->goBy = $goBy;

        return $this;
    }

    /**
     * Get goBy
     *
     * @return integer
     */
    public function getGoBy()
    {
        $key = $this->goBy;
        if ($key !== null) {
            return self::TRANSPORT[$key];
        }
    }

    /**
     * Set stationFrom
     *
     * @param string $stationFrom
     *
     * @return TravelInfo
     */
    public function setStationFrom($stationFrom)
    {
        $this->stationFrom = $stationFrom;

        return $this;
    }

    /**
     * Get stationFrom
     *
     * @return string
     */
    public function getStationFrom()
    {
        return $this->stationFrom;
    }

    /**
     * Set stationTo
     *
     * @param string $stationTo
     *
     * @return TravelInfo
     */
    public function setStationTo($stationTo)
    {
        $this->stationTo = $stationTo;

        return $this;
    }

    /**
     * Get stationTo
     *
     * @return string
     */
    public function getStationTo()
    {
        return $this->stationTo;
    }

    /**
     * Set team
     *
     * @param \Omer\TeamBundle\Entity\ForeignTeam $team
     *
     * @return TravelInfo
     */
    public function setTeam(\Omer\TeamBundle\Entity\ForeignTeam $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Omer\TeamBundle\Entity\ForeignTeam
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return TravelInfo
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
     * Set transportNumber
     *
     * @param string $transportNumber
     *
     * @return TravelInfo
     */
    public function setTransportNumber($transportNumber)
    {
        $this->transportNumber = $transportNumber;

        return $this;
    }

    /**
     * Get transportNumber
     *
     * @return string
     */
    public function getTransportNumber()
    {
        return $this->transportNumber;
    }

    /**
     * Set time
     *
     * @param string $time
     *
     * @return TravelInfo
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user
     *
     * @param \Omer\UserBundle\Entity\OfficialUser $user
     *
     * @return TravelInfo
     */
    public function setUser(\Omer\UserBundle\Entity\OfficialUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Omer\UserBundle\Entity\OfficialUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
