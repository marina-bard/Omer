<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 30.03.17
 * Time: 23:51
 */

namespace Omer\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OfficialUserRepository extends EntityRepository
{
    public function findByRole($role)
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles like :role')
            ->setParameter('role', '%' . $role . '%')
            ->getQuery()
            ->getResult();
    }

    public function findNotAdmin()
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles not like :role')
            ->setParameter('role', '%ADMIN%')
            ->getQuery()
            ->getResult();
    }
}