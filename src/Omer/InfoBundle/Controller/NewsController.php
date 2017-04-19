<?php

namespace Omer\InfoBundle\Controller;

use Omer\InfoBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * News controller.
 *
 * @Route("news")
 */
class NewsController extends Controller
{
    /**
     * Lists all news entities.
     *
     * @Route("/", name="news_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('OmerInfoBundle:News')->findBy([], ['updatedAt' => 'DESC']);

        return $this->render('OmerInfoBundle:news:index.html.twig', array(
            'news' => $news,
        ));
    }

    /**
     * Finds and displays a news entity.
     *
     * @Route("/{id}", name="news_show")
     * @Method("GET")
     */
    public function showAction(News $news)
    {
        $url = $this->get('itm.file.preview.path.resolver')->getUrl($news, 'file');

        return $this->render('OmerInfoBundle:news:show.html.twig', array(
            'news' => $news,
            'url' => $url
        ));
    }
}
