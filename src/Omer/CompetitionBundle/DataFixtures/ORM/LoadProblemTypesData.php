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
        'Problem #1',
        'Problem #2',
        'Problem #3',
        'Problem #4',
        'Problem #5',
        'Problem #6'
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