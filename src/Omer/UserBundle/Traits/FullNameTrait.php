<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 30.01.17
 * Time: 2:38
 */

namespace Omer\UserBundle\Traits;

trait FullNameTrait
{
    public function getFullName($person)
    {
        return $person->getSurname().' '.$person->getName().' '.$person->getPatronymic();
    }
}