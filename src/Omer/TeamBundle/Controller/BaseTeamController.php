<?php

namespace Omer\TeamBundle\Controller;

use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\UserBundle\Entity\CoachUser;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;

/**
 * Team controller.
 *
 * @Route("team")
 */
class BaseTeamController extends Controller
{
    use CurrentUserTrait;

    const TRANS_DOMAIN = [
        'team' => 'OmerTeamBundle',
        'user' => 'OmerUserBundle'
    ];

    /**
     * Creates a new team entity.
     *
     * @Route("/new", name="team_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $team = new ForeignTeam();

        $coach = new CoachUser();
        $team->addCoach($coach);
        $coach->addTeam($team);

        $teamMember = new TeamMember();
        $team->addMember($teamMember);

        $password = $coach->generatePassword();
        $coach->setPlainPassword($password);

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('Omer\TeamBundle\Form\ForeignTeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

//            $this->sendEmail($team, $password);

            return $this->render('@OmerTeam/email/email_request_send_form.html.twig', [
                'email' => $coach->getEmail(),
            ]);
        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }
//
//    /**
//     * Finds and displa{id}/ys a team entity.
//     *
//     * @Route("/{id}/email_request", name="team_email_request")
//     * @Method("GET")
//     */
//    public function sendEmailRequestAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $team = $em->getRepository("OmerTeamBundle:Team")->find([ 'id' => $request->get('id') ]);
//        $coach = $team->getMainCoach();
//
//        $this->sendEmail($team, $request->get('password'));
//
//        return $this->render('@OmerTeam/email/email_request_send_form.html.twig', [
//            'email' => $coach->getEmail(),
//        ]);
//    }

    public function sendEmail($team, $password)
    {
        $coach = $team->getMainCoach();

        $body = $this->get('templating')
            ->render('@OmerTeam/email/email_registration_letter.html.twig', [
                'name' => $coach,
                'username' => $coach->getUsername(),
                'password' => $password
            ]);

        $translator = $this->get('translator');

        $filepath = $this->get('builder.team_excel_builder')->buildTeamExcel($team);

        $message = Swift_Message::newInstance()
            ->setSubject($translator->trans('title', [], 'OmerTeamBundle'))
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($coach->getUsername())
            ->setBody(
                $body, 'text/html'
            )
            ->attach(\Swift_Attachment::fromPath($filepath));
        ;

        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/abort", name="team_new_abort")
     */
    public function indexAction()
    {
        return $this->render('OmerTeamBundle:team:registration_abort.html.twig');
    }
}
