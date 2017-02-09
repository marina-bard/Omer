<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 2:30
 */

namespace Omer\UserBundle\Traits;


trait PasswordGeneratorTrait
{
    public function generatePassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}