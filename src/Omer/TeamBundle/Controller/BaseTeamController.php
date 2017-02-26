<?php

namespace Omer\TeamBundle\Controller;

use Doctrine\ORM\EntityManager;
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
     * @var EntityManager
     */
    protected $em;

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

        $this->em = $this->getDoctrine()->getManager();

        $form = $this->createForm('Omer\TeamBundle\Form\ForeignTeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendEmailToCoaches($team);
            $this->em->persist($team);
            $this->em->flush();

            return $this->render('@OmerTeam/email/email_request_send_form.html.twig', [
            ]);
        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    private function sendEmailToCoaches($team)
    {
        $filepath = $this->get('builder.team_excel_builder')->buildTeamExcel($team);

        $coaches = $team->getCoaches();
        foreach ($coaches as $coach) {
            $password = $coach->generatePassword();
            $coach->setPlainPassword($password);

            $body = $this->get('templating')
                ->render('@OmerTeam/email/email_registration_letter.html.twig', [
                    'name' => $coach,
                    'username' => $coach->getUsername(),
                    'password' => $password
                ]);

            $this->sendEmail($filepath, $body, $coach->getUsername());
        }
    }


    public function sendEmail($filepath, $body, $setTo)
    {
        $translator = $this->get('translator');

        $message = Swift_Message::newInstance()
            ->setSubject($translator->trans('title', [], 'OmerTeamBundle'))
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($setTo)
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
