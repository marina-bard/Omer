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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            $this->generateEmailMessage($team);
//            $this->em->persist($team);
//            $this->em->flush();

            return $this->render('@OmerTeam/email/email_request_send_form.html.twig', [
            ]);
        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    private function generateEmailMessage($team)
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

            $body = $this->get('templating')
                ->render('@OmerTeam/email/email_registration_for_boss.html.twig', [
                    'teamName' => $team->getEnglishTeamName()
                ]);

            $this->sendEmail($filepath, $body, $this->getParameter('mailer_user'));
            $this->sendEmail($filepath, $body, $this->getParameter('to_dev'));
        }
    }


    public function sendEmail($filepath, $body, $setTo)
    {
        $translator = $this->get('translator');

        $message = Swift_Message::newInstance()
            ->setSubject($translator->trans('title', [], 'OmerUserBundle'))
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

    /**
     * @Route("/excel", name="team_excel_form")
     */
    public function excelFormAction()
    {
        $fileDir = $this->get('kernel')->getBundle('OmerTeamBundle')->getPath().'/Resources/templates/team_excel_template.xls';

        $response = new StreamedResponse();
        $response->setCallback(function() use($fileDir) {
            echo file_get_contents($fileDir);
        });

        $content_type = 'application/vnd.ms-excel';

        $response->headers->set('Content-Type', $content_type);
        $contentDisposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, basename($fileDir));
        $response->headers->set('Content-Disposition', $contentDisposition);

        return $response;
    }


}
