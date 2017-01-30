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
    public function getFullName($items)
    {
        return $items[0].' '.$items[1].' '.$items[2];
    }
}