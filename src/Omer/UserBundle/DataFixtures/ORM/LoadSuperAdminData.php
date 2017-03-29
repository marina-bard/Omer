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
use Omer\UserBundle\Entity\OfficialUser;

class LoadSuperAdminData implements FixtureInterface
{
    /**
     * @var OfficialUser
     */
    private $user;

    public function load(ObjectManager $manager)
    {
        $this->createUser($manager, true, 'super_admin');
        $this->createUser($manager, 'ROLE_MAIN_ADMIN', 'admin');
        $manager->flush();
    }

    private function createUser(ObjectManager $manager, $role, $username)
    {
        $this->user = $manager->getRepository('OmerUserBundle:OfficialUser')->findOneBy(['username' => $username]);
        if (!$this->user) {
            $this->user = new OfficialUser();
            $this->user->setUsername($username);
            $this->user->setEmail($username);
            $this->user->setPlainPassword($username);
            $this->user->setFirstName($username);
            $this->user->setSurname($username);
            $this->user->setPatronymic($username);
            $this->setRoles($role);
            $this->user->setEnabled(true);
        }
        else {
            $this->setRoles($role);
        }

        $manager->persist($this->user);
    }

    private function setRoles($role) {
        if ($role === (true || false)) {
            $this->user->setSuperAdmin($role);
        }
        else {
            $this->user->setRoles(array($role));
        }
    }
}
