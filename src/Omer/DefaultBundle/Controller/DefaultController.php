<?php

namespace Omer\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository("OmerInfoBundle:News")
            ->findBy([], ['updatedAt' => 'DESC'], 6);

        return $this->render('OmerDefaultBundle:Default:index.html.twig', [
            'news' => $news
        ]);
    }

    /**
     * @Route("/invitation_ru", name="default_invitation_ru")
     */
    public function invitationRuAction()
    {
        return $this->openPDF('@OmerDefaultBundle/Resources/templates/invitation_ru.pdf');
    }

    /**
     * @Route("/invitation_en", name="default_invitation_en")
     */
    public function invitationEnAction()
    {
        return $this->openPDF('@OmerDefaultBundle/Resources/templates/invitation_en.pdf');
    }

    /**
     * @Route("/teams_schedule", name="default_teams_schedule")
     */
    public function teamsScheduleAction()
    {
        return $this->openPDF('@OmerDefaultBundle/Resources/templates/performance_schedule.pdf');
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
