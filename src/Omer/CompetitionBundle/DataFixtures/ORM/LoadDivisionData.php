<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 06.04.17
 * Time: 23:04
 */

namespace Omer\CompetitionBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Omer\CompetitionBundle\Entity\Division;

class LoadDivisionData implements FixtureInterface
{
    private $divisions = [
        'K-2' => 0,
        'Division I' => 1,
        'Division II' => 2,
        'Division III' => 3,
        'Division IV' => 4,
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->divisions as $key => $value) {
            $division = $manager->getRepository('OmerCompetitionBundle:Division')->findOneBy(['number' => $value]);
            if (!$division) {
                $manager->persist(new Division($key, $value));
            }
            else {
                $division->setTitle($key);
            }
        }

        $manager->flush();
    }
}