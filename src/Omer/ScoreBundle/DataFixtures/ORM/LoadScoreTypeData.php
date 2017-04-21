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
use Omer\ScoreBundle\Entity\ScoreType;

class LoadScoreTypeData implements FixtureInterface
{
    private $types = [
        'title' => [
            'Long-Term Problem',
            'Style',
            'Spontaneous',
            'Mixed',
            'Penalties'
        ],
        'isDependsOnProblem' => [
            true,
            true,
            false,
            false,
            false
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->types['title'] as $key => $value) {
            $type = $manager->getRepository('OmerScoreBundle:ScoreType')->findOneBy(['value' => $key]);
            if (!$type) {
                $manager->persist(new ScoreType($key, $value, $this->types['isDependsOnProblem'][$key]));
            }
            else {
                $type->setType($value);
                $type->setIsDependsOnProblem($this->types['isDependsOnProblem'][$key]);
            }
        }

        $manager->flush();
    }
}
