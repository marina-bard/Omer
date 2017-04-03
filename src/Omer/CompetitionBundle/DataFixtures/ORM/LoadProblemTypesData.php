<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 03.04.17
 * Time: 13:10
 */

namespace Omer\CompetitionBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Omer\CompetitionBundle\Entity\ProblemType;

class LoadProblemTypesData implements FixtureInterface
{
    private $types = [
        '#1 Vehicle',
        '#2 Technical',
        '#3 Classics',
        '#4 Structure',
        '#5 Performance',
        'Primary'
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->types as $type) {
            $value = $manager->getRepository('OmerCompetitionBundle:ProblemType')->findBy(['title' => $type]);
            if (!$value) {
                $manager->persist(new ProblemType($type));
            }
        }
        $manager->flush();
    }
}