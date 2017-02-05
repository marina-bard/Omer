<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 22.7.16
 * Time: 11.37
 */

namespace Omer\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $requestAttributes = $this->get('request_stack')->getCurrentRequest()->attributes;

        if ('admin_login' === $requestAttributes->get('_route')) {
            $template = sprintf('OmerUserBundle:Security:login_admin.html.twig');
            return $this->get('templating')->renderResponse($template, $data);
        }

        return parent::renderLogin($data);
    }
}