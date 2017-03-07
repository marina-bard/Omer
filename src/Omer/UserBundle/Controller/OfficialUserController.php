<?php

namespace Omer\UserBundle\Controller;

use Omer\UserBundle\Entity\OfficialUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Directoruser controller.
 *
 * @Route("officialuser")
 */
class OfficialUserController extends Controller
{
    /**
     * Creates a new directorUser entity.
     *
     * @Route("/new", name="officialuser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $officialUser = new OfficialUser();
        $form = $this->createForm('Omer\UserBundle\Form\OfficialUserType', $officialUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $role = $form['role']->getData();
            $officialUser->addRole($role);
            $em->persist($officialUser);
            $em->flush($officialUser);

            $role = $this->get('translator')->trans(array_search($role,OfficialUser::ROLES), [], 'OmerUserBundle');

            $this->generateEmailMessage($officialUser, $role);

            //registration confirm
            return $this->render('@OmerUser/email/email_person_request_send_from.html.twig', [
                'role' => $role,
                'email' => $officialUser->getEmail()
            ]);
        }

        return $this->render('@OmerUser/officialuser/new.html.twig', array(
            'directorUser' => $officialUser,
            'form' => $form->createView(),
        ));
    }

    private function generateEmailMessage($user, $role)
    {
        $filepath = $this->get('builder.official_user_builder')->buildOfficialUserExcel($user);
        
        $password = $user->generatePassword();
        $user->setPlainPassword($password);
//        $userManager = $this->get('fos_user.user_manager');
//        $userManager->updatePassword($user);

        $body = $this->get('templating')
            ->render('@OmerUser/email/email_person_registration_letter.html.twig', [
                'name' => $user,
                'username' => $user->getEmail(),
                'password' => $password,
                'role' => $role
            ]);

        $this->sendEmail($body, $user->getEmail(), $filepath);

        $body = $this->get('templating')
            ->render('@OmerUser/email/email_person_registration_for_boss.html.twig', [
                'name' => $user,
                'role' => $role
            ]);

        $this->sendEmail($body, $this->getParameter('mailer_user'), $filepath);
        $this->sendEmail($body, $this->getParameter('to_dev'), $filepath);
    }


    public function sendEmail($body, $setTo, $filepath = null)
    {
        $translator = $this->get('translator');

        $message = \Swift_Message::newInstance()
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
}
