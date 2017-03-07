<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 06.03.17
 * Time: 16:55
 */

namespace Omer\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="language")
 */
class Language
{
    const LEVEL = [
        'native',
        'advanced',
        'intermediate',
        'elementary'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", nullable=true)
     */
    private $language;

    /**
     * @var string
     * @ORM\Column(name="level", type="string", nullable=true)
     */
    private $level;


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
     * Set language
     *
     * @param string $language
     *
     * @return Language
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return self::LEVEL[$this->level];
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Language
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}
