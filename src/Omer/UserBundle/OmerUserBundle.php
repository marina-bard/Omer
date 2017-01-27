<?php

namespace Omer\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OmerUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
