<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.04.17
 * Time: 0:50
 */

namespace Omer\ScoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Omer\ScoreBundle\Entity\Point;
use Omer\ScoreBundle\Entity\Score;

class TotalScoreSubscriber implements EventSubscriber
{
    const PRE_PERSIST = 'prePersist';
    const PRE_UPDATE = 'postUpdate';

    //@toDo find out why postUpdate doesn't work
    public function getSubscribedEvents()
    {
        return [
            self::PRE_PERSIST,
//            self::PRE_UPDATE
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Score) {
            $points = $entity->getPoints();

            foreach ($points as $point) {
                if (!$point->getCriterion()->getMaterializedPath()) {
                    $entity->setTotalScore($point->getValue());
                }
            }
        }
    }
}