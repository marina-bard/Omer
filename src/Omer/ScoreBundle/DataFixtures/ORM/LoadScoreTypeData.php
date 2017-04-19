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
        'Scoring',
        'Style',
        'Spontaneous',
        'Mixed',
        'Penalties'
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->types as $key => $value) {
            $type = $manager->getRepository('OmerScoreBundle:ScoreType')->findOneBy(['value' => $key]);
            if (!$type) {
                $manager->persist(new ScoreType($key, $value));
            }
            else {
                $type->setType($value);
            }
        }

        $manager->flush();
    }
}
