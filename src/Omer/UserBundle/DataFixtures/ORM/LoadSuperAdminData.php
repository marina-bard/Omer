<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 23:55
 */

namespace Omer\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Omer\UserBundle\Entity\CoachUser;

class LoadSuperAdminData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new CoachUser();

        $user->setEmail('admin');
        $user->setPlainPassword('admin');
        $user->setName('Admin');
        $user->setSurname('Admin');
        $user->setPatronymic('Admin');
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
    }
}