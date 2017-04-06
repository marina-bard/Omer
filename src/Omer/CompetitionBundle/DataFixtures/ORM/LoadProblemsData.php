<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 07.04.17
 * Time: 0:12
 */

namespace Omer\CompetitionBundle\DataFixtures;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Omer\CompetitionBundle\Entity\Problem;

class LoadProblemsData implements FixtureInterface
{
    private $problems = [
        1 => 'Catch Us If You Can',
        2 => 'Odd-a-Bot',
        3 => "Classics... It's Time, OMER",
        4 => 'Ready, Se, Balsa, Build!',
        5 => 'To Be Continued: A Superhero Cliffhanger',
        6 => "Movin' Out!"
    ];
    public function load(ObjectManager $manager)
    {
        $types = $manager->getRepository('OmerCompetitionBundle:ProblemType')->findAll();
        foreach ($types as $type) {
            $problem = $manager->getRepository('OmerCompetitionBundle:Problem')->findOneBy(['type' => $type]);
            if (!$problem) {
                $problem = new Problem();
                $problem->setType($type);
                $problem->setTitle($this->problems[$type->getNumber()]);
                $manager->persist($problem);
            }
            else {
                $problem->setTitle($this->problems[$type->getNumber()]);
            }
        }
        $manager->flush();
    }
}