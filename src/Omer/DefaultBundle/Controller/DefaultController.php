<?php

namespace Omer\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('OmerDefaultBundle:Default:index.html.twig');
    }

    /**
     * @Route("/invite", name="default_invitation")
     */
    public function invitationAction()
    {
        return $this->openPDF('@OmerDefaultBundle/Resources/templates/invitation.pdf');
    }

    private function openPDF($filepath)
    {
        $kernel = $this->get('kernel');
        $path = $kernel->locateResource($filepath);

        $response = new BinaryFileResponse($path);

        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, //use ResponseHeaderBag::DISPOSITION_ATTACHMENT to save as an attachement
            basename($filepath)
        );

        return $response;
    }
}
