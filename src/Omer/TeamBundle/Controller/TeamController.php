<?php

namespace Omer\TeamBundle\Controller;

use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\UserBundle\Entity\CoachUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 * @Route("team")
 */
class TeamController extends Controller
{
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->sendEmail();
        return $this->redirectToRoute('homepage');
//        $em = $this->getDoctrine()->getManager();
//
//        $teams = $em->getRepository('OmerTeamBundle:Team')->findAll();
//
//        return $this->render('OmerTeamBundle:team:index.html.twig', [
//            'teams' => $teams,
//        ]);
    }

    /**
     * Creates a new team entity.
     *
     * @Route("/new", name="team_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $coach = new CoachUser();
        $team->setCoach($coach);
        $coach->setPlainPassword($this->randomPassword());

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('Omer\TeamBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

//            $this->sendEmail($team);

//            return $this->redirectToRoute('team_show', ['id' => $team->getId()]);
        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    public function randomPassword()
    {
        $pass = [];
        $alphaLength = strlen(self::ALPHABET) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = self::ALPHABET[$n];
        }
        return implode($pass);
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/{id}", name="team_show")
     * @Method("GET")
     */
    public function showAction(Team $team)
    {
        return $this->render('OmerTeamBundle:team:show.html.twig', [
            'team' => $team,
        ]);
    }

    public function sendEmail()
    {
//        die();
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository("OmerTeamBundle:Team")->find(1);
        $coach = $team->getCoach();
        $body = $this->get('templating')
            ->render('OmerTeamBundle:email:registration_letter.html.twig', [
                'name' => $coach
            ]);

        $translator = $this->get('translator');
        $message = \Swift_Message::newInstance()
            ->setSubject($translator->trans('title', [], 'OmerTeamBundle'))
            ->setFrom($this->get('swiftmailer'))
            ->setTo($coach->getUsername())
            ->setBody(
                $body, 'text/html'
            );

        $this->get('mailer')->send($message);

//        $this->redirectToRoute('homepage');
    }
}
