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
        'Problem #1' => 1,
        'Problem #2' => 2,
        'Problem #3' => 3,
        'Problem #4' => 4,
        'Problem #5' => 5,
        'Problem #6' => 6
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->types as $key => $value) {
            $type = $manager->getRepository('OmerCompetitionBundle:ProblemType')->findOneBy(['number' => $value]);
            if (!$type) {
                $manager->persist(new ProblemType($key, $value));
            }
            else {
                $type->setTitle($key);
            }
        }
        $manager->flush();
    }
}