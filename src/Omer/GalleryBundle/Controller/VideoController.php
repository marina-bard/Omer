<?php

namespace Omer\GalleryBundle\Controller;

use Omer\GalleryBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Video controller.
 *
 * @Route("video")
 */
class VideoController extends Controller
{
    /**
     * Lists all video entities.
     *
     * @Route("/", name="video_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $videos = $em->getRepository('OmerGalleryBundle:Video')->findAll();

        return $this->render('@OmerGallery/video/index.html.twig', array(
            'videos' => $videos,
        ));
    }

    /**
     * Finds and displays a video entity.
     *
     * @Route("/{id}", name="video_show")
     * @Method("GET")
     */
    public function showAction(Video $video)
    {
        return $this->render('@OmerGallery/video/show.html.twig', array(
            'video' => $video,
        ));
    }
}
