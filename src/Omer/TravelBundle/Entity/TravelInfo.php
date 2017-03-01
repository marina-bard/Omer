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
        'arrival_info',
        'departure_info'
    ];

    const TRANSPORT = [
        'avia',
        'train',
        'bus',
        'own'
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
     * @ORM\Column(name="transport", type="integer", nullable=true)
     */
    private $transport;

    /**
     * @ORM\Column(name="station_from", type="string", nullable=true)
     */
    private $stationFrom;

    /**
     * @ORM\Column(name="station_to", type="string", nullable=true)
     */
    private $stationTo;

    /**
     * @ORM\Column(name="time", type="time", nullable=true)
     */
    private $time;


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
        return $this->goBy;
    }

    /**
     * Set transport
     *
     * @param integer $transport
     *
     * @return TravelInfo
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return integer
     */
    public function getTransport()
    {
        return $this->transport;
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
     * Set time
     *
     * @param \DateTime $time
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
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
}
