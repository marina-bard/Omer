<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 29.01.17
 * Time: 23:20
 */
namespace Omer\UserBundle\Traits;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

trait CurrentUserTrait
{
    /**
     * @var TokenStorage $tokenStorage
     */
    private $tokenStorage;

    public function setTokenStorage ($tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}