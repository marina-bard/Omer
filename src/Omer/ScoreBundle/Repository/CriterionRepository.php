<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 12.04.17
 * Time: 16:51
 */

namespace Omer\ScoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Knp\DoctrineBehaviors\ORM as ORMBehaviors;

class CriterionRepository extends EntityRepository
{
    use ORMBehaviors\Tree\Tree;
}
