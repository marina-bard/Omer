<?php

namespace Omer\TeamBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use Omer\TeamBundle\Builder\TeamExcelBuilder;
use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\UserBundle\Entity\CoachUser;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Omer\UserBundle\Traits\RandomPasswordTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use Swift_Message;

/**
 * Team controller.
 *
 * @Route("team")
 */
class TeamController extends Controller
{
    use CurrentUserTrait;
    use RandomPasswordTrait;

    const TRANS_DOMAIN = [
        'team' => 'OmerTeamBundle',
        'user' => 'OmerUserBundle'
    ];

    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('OmerTeamBundle:Team')->findAll();

        return $this->render('OmerTeamBundle:team:index.html.twig', [
            'teams' => $teams,
        ]);
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

        $password = $this->getPassword();
        $coach->setPlainPassword($password);

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('Omer\TeamBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_email_request', [
                'id' => $team->getId(),
                'password' => $password
            ]);
        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displa{id}/ys a team entity.
     *
     * @Route("/{id}/email_request", name="team_email_request")
     * @Method("GET")
     */
    public function sendEmailRequestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository("OmerTeamBundle:Team")->find([ 'id' => $request->get('id') ]);
        $coach = $team->getCoach();

        $this->sendEmail($team, $request->get('password'));

        return $this->render('@OmerTeam/email/email_request_send_form.html.twig', [
            'email' => $coach->getEmail(),
        ]);
    }

    public function sendEmail(Team $team, $password)
    {
        $coach = $team->getCoach();

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
}
