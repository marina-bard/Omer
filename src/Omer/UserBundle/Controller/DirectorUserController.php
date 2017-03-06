<?php

namespace Omer\UserBundle\Controller;

use Omer\UserBundle\Entity\DirectorUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Directoruser controller.
 *
 * @Route("directoruser")
 */
class DirectorUserController extends Controller
{
    /**
     * Creates a new directorUser entity.
     *
     * @Route("/new", name="directoruser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $directorUser = new DirectorUser();
        $form = $this->createForm('Omer\UserBundle\Form\DirectorUserType', $directorUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($directorUser);
            $em->flush($directorUser);

//            return $this->redirectToRoute('directoruser_show', array('id' => $directorUser->getId()));
        }

        return $this->render('@OmerUser/directoruser/new.html.twig', array(
            'directorUser' => $directorUser,
            'form' => $form->createView(),
        ));
    }
}
